<?php

namespace Moawiaab\LaravelTheme\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class Budget extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public const STATUS_RADIO = [
        '0' => 'مغلق',
        '1' => 'مفتوح',
    ];

    public $table = 'budgets';

    public $orderable = [
        'id',
        'budget.name',
        'amount',
        'expense_amount',
        'status',
    ];

    public $filterable = [
        'id',
        'budget.name',
        'amount',
        'expense_amount',
        'status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'budget_id',
        'account_id',
        'user_id',
        'stage_id',
        'amount',
        'expense_amount',
        'status',
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

    public function budget()
    {
        return $this->belongsTo(BudgetName::class, 'budget_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function expanses() : HasMany
    {
        return $this->hasMany(Expanse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function getStatusLabelAttribute($value)
    {
        return static::STATUS_RADIO[$this->status] ?? null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
