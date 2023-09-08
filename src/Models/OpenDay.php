<?php

namespace Moawiaab\LaravelTheme\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Moawiaab\LaravelTheme\Support\HasAdvancedFilter;

class OpenDay extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    public $table = 'open_days';

    public $orderable = [
        'id',
        'user.name',
        'admin.name',
        'amount',
        'problem',
        'on_open',
        'created_at',
        'updated_at',
    ];

    public $filterable = [
        'id',
        'user.name',
        'admin.name',
        'amount',
        'problem',
        'on_open',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'problem',
        'on_open'
    ];


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            } elseif($trashed === 'new') {
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
        return $this->belongsTo(User::class, 'user_updated_id');
    }


    public function locker()
    {
        return $this->belongsTo(PrivateLocker::class, 'locker_id');
    }
    public function scopeLocker($query, $id)
    {
        return $query->where('locker_id', $id)->paginate(request('limit', 10));
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
