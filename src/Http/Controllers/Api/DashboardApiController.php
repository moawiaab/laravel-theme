<?php

namespace Moawiaab\LaravelTheme\Http\Controllers\Api;

use App\Events\HelloWorld;
use App\Http\Controllers\Controller;
use Moawiaab\LaravelTheme\Services\ChartsService;
use Moawiaab\LaravelTheme\Services\FiscalYearService;

class DashboardApiController extends Controller
{

    public function __construct()
    {
        FiscalYearService::checkStage();
    }
    public function index()
    {
        $bar = new ChartsService([
            'title'              => 'Ok Amount', // العنوان
            'chart_type'         => 'bar',  // النوع Line و Pie و bar
            'model'              => 'App\Models\User',
            'group_by_field'     => 'created_at',
            'group_by_period'    => 'day',
            'column_class'       => 'col-md-12',
            'aggregate_function' => '', // count , sum ,avg
            'aggregate_field'    => '', // العمود يستحدم sum . avg
            'filter_by_field'    => 'created_at', // يستخدم مع filter_by_period
            'filter_by_period'   => 30, // العدد
        ]);

        $line = new ChartsService([
            'title'              => 'Ok Amount', // العنوان
            'chart_type'         => 'line',  // النوع Line و Pie و bar
            'model'              => 'App\Models\User',
            'group_by_field'     => 'created_at',
            'group_by_period'    => 'day',
            'column_class'       => 'col-md-12',
            'aggregate_function' => 'sum', // count , sum ,avg
            'aggregate_field'    => 'amount', // العمود يستحدم sum . avg
            'filter_by_field'    => 'created_at', // يستخدم مع filter_by_period
            'filter_by_period'   => 30, // العدد
        ]);

        $pie = new ChartsService([
            'title'              => 'Ok Amount', // العنوان
            'chart_type'         => 'pie',  // النوع Line و Pie و bar
            'model'              => 'App\Models\User',
            'group_by_field'     => 'created_at',
            'group_by_period'    => 'day',
            'column_class'       => 'col-md-12',
            'aggregate_function' => 'count', // count , sum ,avg
            'aggregate_field'    => 'amount', // العمود يستحدم sum . avg
            'filter_by_field'    => 'created_at', // يستخدم مع filter_by_period
            'filter_by_period'   => 20, // العدد
        ]);

        // dd($chart1);
        $dataNum = [
            'user' => auth()->user()->account->users()->count(),
            'client' => 5,
            'product' => 8,
            'store' => 2,
        ];

       
        return [
            'barChart'  => $bar,
            'lineChart'  => $line,
            'pieChart'  => $pie,
            'num'      => $dataNum,
        ];
    }
}
