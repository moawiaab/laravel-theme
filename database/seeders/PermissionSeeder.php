<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'description' => 'الرئيسية',
                'guard_name' => 'web',
                'name' => 'dashboard_access',
            ],
            [
                'description' => 'مجموعة الشركات',
                'guard_name' => 'web',
                'name' => 'group_access',
            ],

            [
                'description' => 'عرض الفروع',
                'guard_name' => 'web',
                'name' => 'account_access',
            ],
            [
                'description' => 'إنشاء فرع جديد',
                'guard_name' => 'web',
                'name' => 'account_create',
            ],
            [
                'description' => 'تعديل الفرع',
                'guard_name' => 'web',
                'name' => 'account_edit',
            ],
            [
                'description' => 'حذف الفرع',
                'guard_name' => 'web',
                'name' => 'account_delete',
            ],
            [
                'description' => 'عرض الأذونات',
                'guard_name' => 'web',
                'name' => 'permission_access',
            ],

            [
                'description' => 'إدارة المستخدمين',
                'guard_name' => 'web',
                'name' => 'user_management_access',
            ],

            // [
            //     'description' => 'إنشاء إذن جديد',
            //     'guard_name' => 'web',
            //     'name' => 'permission_create',
            // ],
            // [
            //     'description' => 'تعديل الإذن',
            //     'guard_name' => 'web',
            //     'name' => 'permission_edit',
            // ],
            // [
            //     'description' => 'حذف الإذن',
            //     'guard_name' => 'web',
            //     'name' => 'permission_delete',
            // ],
            [
                'description' => 'عرض المستخدمين',
                'guard_name' => 'web',
                'name' => 'user_access',
            ],
            [
                'description' => 'إنشاء مستخدم جديد',
                'guard_name' => 'web',
                'name' => 'user_create',
            ],
            [
                'description' => 'تعديل المستخدم',
                'guard_name' => 'web',
                'name' => 'user_edit',
            ],
            [
                'description' => 'حذف المستخدم',
                'guard_name' => 'web',
                'name' => 'user_delete',
            ],

            [
                'description' => 'عرض الصلاحيات',
                'guard_name' => 'web',
                'name' => 'role_access',
            ],
            [
                'description' => 'إنشاء صلاحية جديدة',
                'guard_name' => 'web',
                'name' => 'role_create',
            ],
            [
                'description' => 'تعديل الصلاحية',
                'guard_name' => 'web',
                'name' => 'role_edit',
            ],
            [
                'description' => 'حذف الصلاحية',
                'guard_name' => 'web',
                'name' => 'role_delete',
            ],
            [
                'description' => 'الخزنة العامة',
                'guard_name' => 'web',
                'name' => 'public_treasury_access',
            ],
            [
                'description' => 'حذف الواردات من الخزنة العامة',
                'guard_name' => 'web',
                'name' => 'public_treasury_delete',
            ],
            [
                'description' => ' المالية العامة ',
                'guard_name' => 'web',
                'name' => 'financial_management_access',
            ],

            [
                'description' => 'عرض السنة المالية',
                'guard_name' => 'web', //
                'name' => 'stage_access',
            ],
            [
                'description' => 'إنشاء سنة مالية جديدة',
                'guard_name' => 'web', //
                'name' => 'stage_create',
            ],
            [
                'description' => 'تعديل السنة المالية',
                'guard_name' => 'web', //
                'name' => 'stage_edit',
            ],
            [
                'description' => 'حذف السنة المالية',
                'guard_name' => 'web', //
                'name' => 'stage_delete',
            ],

            [
                'description' => 'عرض المصروفات',
                'guard_name' => 'web',
                'name' => 'expanse_access',
            ],
            [
                'description' => 'إنشاء مصروف جديد',
                'guard_name' => 'web',
                'name' => 'expanse_create',
            ],
            [
                'description' => 'تعديل المصروف',
                'guard_name' => 'web',
                'name' => 'expanse_edit',
            ],
            [
                'description' => 'حذف المصروف',
                'guard_name' => 'web',
                'name' => 'expanse_delete',
            ],

            [
                'name' => 'private_locker_create',
                'description' => 'انشاء خزنة شخصية',
                'guard_name' => 'web',
            ],

            [
                'name' => 'private_locker_edit',
                'description' => 'تعديل  الخزنة الشخصية',
                'guard_name' => 'web',
            ],

            [
                'name' => 'private_locker_delete',
                'description' => ' حذف الخزنة الشخصية',
                'guard_name' => 'web',
            ],

            [
                'name' => 'private_locker_access',
                'description' => ' عرض الخزائن الشخصية',
                'guard_name' => 'web',
            ],


            [
                'name' => 'budget_name_create',
                'description' => 'انشاء اسم موازنة جديدة',
                'guard_name' => 'web',
            ],

            [
                'name' => 'budget_name_edit',
                'description' => 'تعديل اسم الموازنة',
                'guard_name' => 'web',
            ],

            [
                'name' => 'budget_name_delete',
                'description' => ' حذف  اسم الموازنة',
                'guard_name' => 'web',
            ],

            [
                'name' => 'budget_name_access',
                'description' => ' عرض اسماء الموازنة',
                'guard_name' => 'web',
            ],


            [
                'description' => 'عرض الموازنة العامة',
                'guard_name' => 'web',
                'name' => 'budget_access',
            ],
            [
                'description' => 'إنشاء موازنة جديدة',
                'guard_name' => 'web',
                'name' => 'budget_create',
            ],
            [
                'description' => 'تعديل الموازنة',
                'guard_name' => 'web',
                'name' => 'budget_edit',
            ],
            [
                'description' => 'حذف الموازنة',
                'guard_name' => 'web',
                'name' => 'budget_delete',
            ],



        ];
        Permission::insert($permissions);
    }
}
