<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class Basic extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAdvancedFilter;


    // protected $table = 'tablesName';

    protected $orderable = [
        'id',
        'name',
    ];

    protected $filterable = [
        'id',
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'user_id',
        'account_id',
        'created_at',
        'updated_at',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }
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

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //function
}
