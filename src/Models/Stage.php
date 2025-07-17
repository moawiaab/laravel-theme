<?php

namespace Moawiaab\LaravelTheme\Models;

use App\Models\User;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class Stage extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    public $table = 'stages';

    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'name',
        'start_date',
        'end_date',
        'status',
        'gain',
        'user.name',
    ];

    protected $filterable = [
        'id',
        'name',
        'start_date',
        'end_date',
        'status',
        'user.name',
    ];

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'status',
        'user_id',
        'fiscal_year_id',
        'account_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function budgets() : HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getItemAttribute($id)
    {
        return $id;
        // dd($id);
        // return $this->hasMany(ProductStore::class, "store_id");
    }



    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
