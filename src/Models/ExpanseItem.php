<?php

namespace Moawiaab\LaravelTheme\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class ExpanseItem extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public $table = 'expanse_items';

    public const STATUS_RADIO = [
        '1' => 'New',
        '0' => 'End',
    ];

    public $orderable = [
        'id',
        'amount',
        'details',
        'user.name',
        'admin.name',
        'created_at',
        'updated_at',
    ];

    public $filterable = [
        'id',
        'amount',
        'details',
        'user.name',
        'admin.name',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'status',
        'amount',
        'details',
        'expanse_id',
    ];

    public function getStatusLabelAttribute($value)
    {
        return static::STATUS_RADIO[$this->status] ?? null;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function scopeExpanse($query, $id)
    {
        return $query->where('expanse_id', $id)->paginate(request('limit', 10));
    }

    public function expanse()
    {
        return $this->belongsTo(Expanse::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
