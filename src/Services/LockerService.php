<?php

namespace Moawiaab\LaravelTheme\Services;

use Moawiaab\LaravelTheme\Models\PrivateLocker;

class LockerService
{

    public static $error = "";

    public static function check()
    {
        if (!auth()->user()->locker) {
            if (auth()->user()->account->setting()->locker_conf == 1) {
                $safe = new PrivateLocker();
                $safe->amount = 0;
                $safe->on_open = 0;
                $safe->problem = 0;
                $safe->status  = 1;
                $safe->admin_id = auth()->id();
                $safe->user_id = auth()->id();
                $safe->account_id = auth()->user()->account_id;
                $safe->save();
                return false;
            } else {
                self::$error = "ليس لديك خزنة شخصية قم بإنشاء خزنة ثم حاول لاحقا";
            }
        } elseif (auth()->user()->locker->status == 0) {
            self::$error = "الخزنة الشخصية مقفولة قم بفتحها ثم حاول لاحقاً";
        } else {
            return false;
        }

        // self::$error = "Locker";
        return true;
    }
}
