<?php

namespace Moawiaab\LaravelTheme\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'exp_roof',
        'exp_conf',
        'account_id',
        'locker_conf'
    ];
}
