<?php

namespace Moawiaab\LaravelTheme\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class BudgetName extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public const TYPE_RADIO = [
        '0' => 'اسم خاص بهذا الفرع',
        '1' => ' اسم عام لكل الفروع',
    ];

    public const STATUS_RADIO = [
        '0' => 'مغلق',
        '1' => 'مفتوح',
    ];

    public $table = 'budget_names';

    public $orderable = [
        'id',
        'name',
        'details',
        'type',
        'status',
    ];

    public $filterable = [
        'id',
        'name',
        'details',
        'type',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'details',
        'type',
        'status',
        'account_id',
        'user_id',
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

    public function getTypeLabelAttribute($value)
    {
        return static::TYPE_RADIO[$this->type] ?? null;
    }

    public function getStatusLabelAttribute($value)
    {
        return static::STATUS_RADIO[$this->status] ?? null;
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function budget(): HasMany
    {
        return $this->hasMany(Budget::class, 'budget_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
