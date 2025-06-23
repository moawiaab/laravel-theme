<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Moawiaab\LaravelTheme\Models\Account;
use Spatie\Permission\Models\Role;

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
                'description'    => 'المدير العام',
                'name'           => 'Super Admin',
                'guard_name'     => 'web',
                'created_at'     => now(),
            ],
            [
                'id'             => 2,
                'description'    => 'مدير فرع',
                'name'           => 'Admin',
                'guard_name'     => 'web',
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
                'account_id'     => 1,
                'created_at'     => now(),
            ],
            [
                'id'             => 2,
                'name'           => 'User Admin',
                'email'          => 'user@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'account_id'     => 2,
                'created_at'     => now(),
            ],
        ];

        User::insert($users);
        $admin = User::find(1);
        $admin->assignRole('Super Admin');
        $user = User::find(2);
        $user->assignRole('Admin');
    }
}
