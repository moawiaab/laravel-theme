<?php

namespace Moawiaab\LaravelTheme\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class SupplierOrderItem extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public const TYPE_RADIO = [
        '1' => 'open',
        '0' => 'close',
    ];


    public $orderable = [
        'id',
        'num',
        'amount',
        'product.name',
        'user.name',
        'user_check.name',
        'type',
    ];

    public $filterable = [
        'id',
        'num',
        'amount',
        'product.name',
        'user.name',
        'user_check.name',
        'type',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'num',
        'amount',
        'product_id',
        'type',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['type'] ?? null, function ($query, $trashed) {
            if ($trashed === 'new') {
                $query->where('status', 1);
            } elseif ($trashed === 'end') {
                $query->where('status', 0);
            }
        });
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
    public function items()
    {
        return $this->hasMany(Weight::class, 'item_id')->where('status', 0)->where('type', 1);
    }

    public function order()
    {
        return $this->belongsTo(SupplierOrder::class, 'order_id');
    }

    public function getMyAmountAttribute()
    {
        return $this->amount * $this->num;
    }

    public function getAllAmountAttribute()
    {
        return ($this->price * $this->num) - ($this->amount * $this->num);
    }

    public function getMyPriceAttribute()
    {
        return $this->price * $this->num;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userCheck()
    {
        return $this->belongsTo(User::class, 'user_check_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
