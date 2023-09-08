<?php

namespace Moawiaab\LaravelTheme\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class PublicTreasury extends Model
{
    use HasAdvancedFilter;
    use SoftDeletes;
    use HasFactory;

    public $table = 'public_treasuries';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $orderable = [
        'id',
        'name',
        'amount',
        'take_amount',
        'add_amount',
        'status',
        'user.name',
        'account.name',
    ];

    protected $filterable = [
        'id',
        'name',
        'amount',
        'take_amount',
        'add_amount',
        'status',
        'user.name',
        'account.name',
    ];

    protected $fillable = [
        'name',
        'amount',
        'take_amount',
        'add_amount',
        'status',
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

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
