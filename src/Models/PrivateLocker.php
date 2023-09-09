<?php

namespace Moawiaab\LaravelTheme\Models;

use App\Models\User;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class PrivateLocker extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    public $table = 'private_lockers';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'amount',
        'status',
        'problem',
        'on_open',
        'user.name',
        'account.name',
    ];

    protected $filterable = [
        'id',
        'amount',
        'status',
        'problem',
        'on_open',
        'user.name',
        'account.name',
    ];

    protected $fillable = [
        'amount',
        'status',
        'problem',
        'on_open',
        'user_id',
        'account_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OpenDay::class, 'locker_id')->orderBy('id', 'desc');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
