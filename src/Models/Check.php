<?php

namespace Moawiaab\LaravelTheme\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class Check extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    protected $orderable = [
        'id',
        'name',
        'status',
        'details',
        'num',
        'amount',
        'bank',
        'created_at',
    ];

    protected $filterable = [
        'id',
        'name',
        'status',
        'details',
        'num',
        'amount',
        'bank',
        'created_at',
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
            } elseif($trashed === 'new') {
                $query->where("status", 1);
            }elseif($trashed === 'end') {
                $query->where("status", 0);
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier () {
        return $this->belongsTo(Supplier::class);
    }

    public function client () {
        return $this->belongsTo(Client::class);
    }
}
