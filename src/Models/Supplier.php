<?php

namespace Moawiaab\LaravelTheme\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class Supplier extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public const STATUS_RADIO = [
        '1' => 'مفتوح',
        '0' => 'مغلق',
    ];

    public $orderable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'amount',
        'status',
    ];

    public $filterable = [
        'id',
        'name',
        'email',
        'phone',
        'address',
        'amount',
        'status',
    ];

    protected $fillable = [
        'name',
        'email',
        'amount',
        'phone',
        'address',
        'status',
        'user_id',
        'account_id',
        'created_at',
        'updated_at',
        'deleted_at',
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

    public function toggle()
    {
        return $this->status;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute($value)
    {
        return static::STATUS_RADIO[$this->status] ?? null;
    }


    public function items () {
        return $this->hasMany(FinancialSupplier::class)->orderBy('id','desc')->take(5);
    }

}
