<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Moawiaab\LaravelTheme\Models\Account;
use Moawiaab\LaravelTheme\Models\Role;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'id'             => 1,
                'title'          => 'المدير العام',
                'account_id'     => 1,
                'created_at'     => now(),
            ],
            [
                'id'             => 2,
                'title'          => 'مدير فرع',
                'account_id'     => 1,
                'created_at'     => now(),
            ],
        ];

        Role::insert($role);
        $account = [
            [
                'id'             => 1,
                'name'           => 'الحساب العامة',
                'details'        => 'تفاصيل الحساب العامة',
                'status'         => 1,
                'phone'          => 25985222,
                'created_at'     => now(),
            ],
            [
                'id'             => 2,
                'name'           => 'الفرع الرئيسي',
                'details'        => 'تفاصيل الفرع',
                'status'         => 1,
                'phone'          => 25985222,
                'created_at'     => now(),
            ],
        ];

        Account::insert($account);
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'role_id'        => 1,
                'account_id'     => 1,
                'created_at'     => now(),
            ],
            [
                'id'             => 2,
                'name'           => 'User Admin',
                'email'          => 'user@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'role_id'        => 2,
                'account_id'     => 2,
                'created_at'     => now(),
            ],
        ];

        User::insert($users);
    }
}
