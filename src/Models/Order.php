<?php

namespace Moawiaab\LaravelTheme\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class Order extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public const TYPE_RADIO = [
        '1' => 'مفتوح',
        '0' => 'مغلق',
    ];

    public $orderable = [
        'id',
        'name',
        'amount',
    ];

    public $filterable = [
        'id',
        'name',
        'amount',
    ];

    protected $fillable = [
        'type',
        'amount',
        'details',
        'user_id',
        'client_id',
        'account_id',
        'supplier_id',
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

    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function getStatusLabelAttribute($value)
    {
        return static::TYPE_RADIO[$this->status] ?? null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function client () {
        return $this->belongsTo(Client::class);
    }

    public function scopeClient($query, $id)
    {
        return $query->where('client_id', $id)->paginate(request('limit', 20));
    }
}
