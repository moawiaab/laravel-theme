<?php

namespace Moawiaab\LaravelTheme\Models;

use App\Models\User;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class Expanse extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    public $table = 'expanses';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'amount',
        'beneficiary',
        'text_amount',
        'details',
        'user.name',
    ];

    protected $filterable = [
        'id',
        'amount',
        'beneficiary',
        'text_amount',
    ];

    protected $fillable = [
        'amount',
        'beneficiary',
        'user_id',
        'administrative_id',
        'account_id',
        'stage_id',
        'text_amount',
        'details',
        'status',
        'budget_id',
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
            }elseif($trashed === 'new') {
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

    public function admin()
    {
        return $this->belongsTo(User::class, 'administrative_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function items()
    {
        return $this->hasMany(ExpanseItem::class, 'expanse_id')->orderBy('id', 'desc');
    }
}
