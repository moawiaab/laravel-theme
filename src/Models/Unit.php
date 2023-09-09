<?php

namespace Moawiaab\LaravelTheme\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class Unit extends Model
{
    use HasFactory;
    use HasAdvancedFilter;

    protected $orderable = [
        'id',
        'name',
        'num',
    ];

    protected $filterable = [
        'id',
        'name',
        'num',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'num',
        'created_at',
        'updated_at',
    ];


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
