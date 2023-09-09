<?php

namespace Moawiaab\LaravelTheme\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Back extends Model
{
    use HasFactory;
    

    public function pro()
    {
        return $this->belongsTo(Product::class, 'pro_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function item()
    {
        return $this->belongsTo(OrderItem::class, 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_id');
    }

    // public function getStatusLabelAttribute($value)
    // {
    //     return static::STATUS_RADIO[$this->status] ?? null;
    // }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['type'] ?? null, function ($query, $type) {
            if ($type == 2) {
                $query->where('status', 1);
            } elseif ($type == 1) {
                $query->where('status', 0);
            }
        });;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s') ?? '-';
    }
}
