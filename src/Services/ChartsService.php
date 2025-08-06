<?php

namespace Moawiaab\LaravelTheme\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\JsonEncodingException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JsonSerializable;

class ChartsService implements Arrayable, Jsonable, JsonSerializable
{
    protected $options;

    protected $attributes;

    protected $type;

    protected $model;

    protected $group_by_field;

    protected $group_by_period;

    protected $filter_by_field;

    protected $filter_by_period;

    protected $usedColors = [];

    protected $colorSet;

    protected $aggregate_function;

    protected $aggregate_field;

    public const GROUP_PERIODS = [
        'day'   => 'Y-m-d',
        'week'  => 'Y-W',
        'month' => 'Y-m',
        'year'  => 'Y',
    ];

    public function __construct(array $options)
    {
        $this->options    = $options;
        $this->attributes = [];

        $this->validate($this->options);

        $this->type  = $this->options['chart_type'];
        $this->model = new $this->options['model']();

        $this->group_by_field  = data_get($this->options, 'group_by_field', null);
        $this->group_by_period = data_get($this->options, 'group_by_period', null);

        $this->filter_by_field  = data_get($this->options, 'filter_by_field', null);
        $this->filter_by_period = data_get($this->options, 'filter_by_period', null);

        $this->aggregate_function = data_get($this->options, 'aggregate_function', null);
        $this->aggregate_field    = data_get($this->options, 'aggregate_field', null);

        $this->make();
    }

    protected function validate(array $options)
    {
        $rules = [
            'title'            => 'required|bail',
            'chart_type'       => 'required|in:bar,line,pie,stats,latest|bail',
            'model'            => 'required|bail',
            'filter_by_field'  => 'sometimes|string|bail',
            'filter_by_period' => 'required_with:filter_by_field|string|bail',
            'group_by_field'   => 'required_if:chart_type,bar,line,pie|string|bail',
            'group_by_period'  => 'required_with:group_by_field|in:day,week,month,year|bail',
            'footer_icon'      => 'sometimes|string|bail',
            'footer_text'      => 'sometimes|string|bail',
            'limit'            => 'required_if:chart_type,latest|integer|bail',
            'fields'           => 'sometimes|array|bail',
            'fields.*'         => 'string',
            'icon'             => 'sometimes|string|bail',
            'color'            => 'sometimes|string|bail',
            'legend'           => 'sometimes|string|bail',
            'column_class'     => 'sometimes|string|bail',
            'chartjs_options'  => 'sometimes|array|bail',
        ];

        if (isset($this->options['filter_by_period'])) {
            $type = gettype($options['filter_by_period']);
            if ($type === 'integer') {
                $rules['filter_by_period'] = 'required|integer|bail';
            } else {
                $rules['filter_by_period'] = 'required|in:week,month,year|bail';
            }
        }

        $validator = Validator::make($options, $rules);

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }
    }

    protected function make()
    {
        $this->setAttr('title', $this->options['title']);
        $this->setAttr('type', ucfirst($this->type));
        $this->setAttr('icon', $this->getIcon());
        $this->setAttr('column_class', $this->getColumnClass());

        if (in_array($this->type, ['line', 'bar', 'pie'])) {
            $this->handleChartjsCharts();
        }

        if ($this->type === 'stats') {
            $this->handleStatsCard();
        }

        if ($this->type === 'latest') {
            $this->handleLatestEntries();
        }
    }

    protected function handleLatestEntries()
    {
        $query  = $this->getQuery();
        $fields = data_get($this->options, 'fields', []);

        foreach ($fields as $field) {
            if ($this->isNestedColumn($field)) {
                [$relation, $column] = explode('.', $field);
                $query->with($relation);
            }
        }

        $collection = $query->latest()
            ->take($this->options['limit'])
            ->get();

        $this->setAttr('data', $collection);
        $this->setAttr('fields', $fields);
    }

    protected function isNestedColumn($column)
    {
        return strpos($column, '.') !== false;
    }

    protected function handleStatsCard()
    {
        $this->setAttr('footer_icon', data_get($this->options, 'footer_icon', ''));
        $this->setAttr('footer_text', data_get($this->options, 'footer_text', ''));

        if ($this->aggregate_function === 'avg' && $this->aggregate_field) {
            $this->setAttr('data', $this->getQuery()->avg($this->aggregate_field));
        } elseif ($this->aggregate_function === 'sum' && $this->aggregate_field) {
            $this->setAttr('data', $this->getQuery()->sum($this->aggregate_field));
        } else {
            $this->setAttr('data', $this->getQuery()->count());
        }
    }

    protected function getQuery()
    {
        return $this->model::when($this->filter_by_field && $this->filter_by_period, function ($q) {
            return $q->where($this->filter_by_field, '>=', $this->getFilterByPeriod());
        });
    }

    protected function handleChartjsCharts()
    {
        $this->setAttr('options', $this->getChartjsOptions());

        $dataset    = [];
        $collection = $this->getQuery()->get();

        if (! $collection->count()) {
            return;
        }

        $this->applyGroupBy($collection)
            ->each(function ($item, $key) use (&$dataset) {
                if ($this->aggregate_function === 'avg' && $this->aggregate_field) {
                    $dataset['labels'][] = $key;
                    $dataset['series'][] = $item->avg($this->aggregate_field);
                } elseif ($this->aggregate_function === 'sum' && $this->aggregate_field) {
                    $dataset['labels'][] = $key;
                    $dataset['series'][] = $item->sum($this->aggregate_field);
                } else {
                    $dataset['labels'][] = $key;
                    $dataset['series'][] = $item->count($this->group_by_field);
                }
            });

        $this->setSeries($dataset);
    }

    protected function applyGroupBy($collection)
    {
        return $collection->sortBy($this->group_by_field)
            ->groupBy(function ($item) {
                if ($this->isDateField($this->group_by_field)) {
                    if (is_null($item->{$this->group_by_field})) {
                        return 'NULL';
                    }

                    return $item->{$this->group_by_field}->format($this->getGroupByPeriod());
                } elseif ($this->isNestedColumn($this->group_by_field)) {
                    [$relation, $column] = explode('.', $this->group_by_field);

                    return $item->{$relation}->{$column};
                } else {
                    if (is_null($item->{$this->group_by_field})) {
                        return 'NULL';
                    }

                    return $item->{$this->group_by_field};
                }
            });
    }

    protected function setSeries(array $dataset)
    {
        $this->setAttr('labels', $dataset['labels']);

        if ($this->type === 'bar') {
            $this->setAttr('datasets', [[
                'label'           => $this->getLegend(),
                'backgroundColor' => $this->getColor($this->options['title']),
                'data'            => $dataset['series'],
            ]]);
        } elseif ($this->type === 'line') {
            $this->setAttr('datasets', [[
                'label'       => $this->getLegend(),
                'fill'        => true,
                'borderColor' => $this->getColor($this->options['title']),
                'data'        => $dataset['series'],
            ]]);
        } elseif ($this->type === 'pie') {
            $background_colors = [];

            foreach ($dataset['labels'] as $label) {
                $background_colors[] = $this->getColor($label);
            }

            $this->setAttr('datasets', [[
                'data'            => $dataset['series'],
                'backgroundColor' => $background_colors,
            ]]);
        }
    }

    protected function getChartjsOptions()
    {
        if (isset($this->options['chartjs_options'])) {
            return $this->options['chartjs_options'];
        } elseif (in_array($this->type, ['line', 'bar'], true)) {
            return [
                'height' => 300,
                'scales' => [
                    'yAxes' => [[
                        'ticks' => [
                            'beginAtZero' => true,
                        ],
                    ]],
                ],
                'responsive'          => true,
                'maintainAspectRatio' => false,
            ];
        } elseif ($this->type === 'pie') {
            return [
                'responsive'          => true,
                'maintainAspectRatio' => false,
            ];
        }

        return [];
    }

    protected function getColumnClass()
    {
        return data_get($this->options, 'column_class', 'col-md-12');
    }

    protected function getLegend()
    {
        if (isset($this->options['legend'])) {
            return $this->options['legend'];
        }

        if ($this->aggregate_function === 'avg') {
            return 'Average';
        }

        if ($this->aggregate_function === 'sum') {
            return 'Sum';
        }

        return data_get($this->options, 'legend', 'Count');
    }

    protected function getIcon()
    {
        if (isset($this->options['chart_icon'])) {
            return $this->options['chart_icon'];
        } elseif ($this->type === 'bar') {
            return 'bar_chart';
        } elseif ($this->type === 'line') {
            return 'multiline_chart';
        } elseif ($this->type === 'pie') {
            return 'pie_chart';
        } elseif ($this->type === 'stats') {
            return 'trending_up';
        } elseif ($this->type === 'latest') {
            return 'table_chart';
        }

        return 'show_chart';
    }

    protected function getColor(string $value)
    {
        if (isset($this->options['chart_color'])) {
            return $this->options['chart_color'];
        }

        $allColors = [
            '300' => ['#e57373', '#f06292', '#ba68c8', '#7986cb', '#64b5f6', '#4dd0e1', '#4db6ac', '#81c784', '#fff176', '#ffb74d', '#a1887f', '#e0e0e0'],
            '500' => ['#f44336', '#e91e63', '#9c27b0', '#3f51b5', '#2196f3', '#673ab7', '#009688', '#4caf50', '#ffeb3b', '#ff9800', '#795548', '#9e9e9e'],
            '700' => ['#d32f2f', '#c2185b', '#7b1fa2', '#303f9f', '#1976d2', '#0097a7', '#00796b', '#388e3c', '#fbc02d', '#f57c00', '#5d4037', '#616161'],
        ];

        if (! $this->colorSet) {
            $this->colorSet = array_keys($allColors)[0];
        }

        $currentColors = $allColors[$this->colorSet];

        if (count($this->usedColors) === count($currentColors)) {
            $this->usedColors = [];
            $sets             = array_keys($allColors);
            $this->colorSet   = $sets[(array_search($this->colorSet, $sets) + 1) % count($sets)];
            $currentColors    = $allColors[$this->colorSet];
        }

        $colors = array_values(array_diff($currentColors, $this->usedColors));

        $hash = 0;
        foreach (str_split($value) as $c) {
            $hash = ord($c) + (($hash << 5) - $hash);
        }

        $index              = abs(($hash) % count($colors));
        $pickedColor        = $colors[$index];
        $this->usedColors[] = $pickedColor;

        return $pickedColor;
    }

    protected function getGroupByPeriod()
    {
        return static::GROUP_PERIODS[$this->group_by_period];
    }

    protected function getFilterByPeriod()
    {
        if ($this->filter_by_period === 'week') {
            return date('Y-m-d', strtotime('last Monday'));
        } elseif ($this->filter_by_period === 'month') {
            return date('Y-m') . '-01';
        } elseif ($this->filter_by_period === 'year') {
            return date('Y') . '-01-01';
        }

        return now()->startOfDay()->subDays($this->filter_by_period - 1);
    }

    protected function isDateField(string $field)
    {
        $date_fields = $this->model->getDates();

        return in_array($this->group_by_field, $date_fields, true);
    }

    public function setAttr(string $key, $value)
    {
        data_set($this->attributes, $key, $value);
    }

    public function toArray()
    {
        return array_merge($this->attributesToArray());
    }

    public function attributesToArray()
    {
        return $this->attributes;
    }

    public function toJson($options = 0)
    {
        $json = json_encode($this->jsonSerialize(), $options);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw JsonEncodingException::forModel($this, json_last_error_msg());
        }

        return $json;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
