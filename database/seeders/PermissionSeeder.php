<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Moawiaab\LaravelTheme\Models\Permission;

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
                'details' => 'الرئيسية',
                'status' => 1,
                'title' => 'dashboard_access',
            ],
            [
                'details' => 'مجموعة الشركات',
                'status' => 0,
                'title' => 'group_access',
            ],

            [
                'details' => 'عرض الفروع',
                'status' => 0,
                'title' => 'account_access',
            ],
            [
                'details' => 'إنشاء فرع جديد',
                'status' => 0,
                'title' => 'account_create',
            ],
            [
                'details' => 'تعديل الفرع',
                'status' => 0,
                'title' => 'account_edit',
            ],
            [
                'details' => 'حذف الفرع',
                'status' => 0,
                'title' => 'account_delete',
            ],
            [
                'details' => 'عرض الأذونات',
                'status' => 0,
                'title' => 'permission_access',
            ],

            [
                'details' => 'إدارة المستخدمين',
                'status' => 1,
                'title' => 'user_management_access',
            ],

            [
                'details' => 'إنشاء إذن جديد',
                'status' => 0,
                'title' => 'permission_create',
            ],
            [
                'details' => 'تعديل الإذن',
                'status' => 0,
                'title' => 'permission_edit',
            ],
            [
                'details' => 'حذف الإذن',
                'status' => 0,
                'title' => 'permission_delete',
            ],
            [
                'details' => 'عرض المستخدمين',
                'status' => 1,
                'title' => 'user_access',
            ],
            [
                'details' => 'إنشاء مستخدم جديد',
                'status' => 1,
                'title' => 'user_create',
            ],
            [
                'details' => 'تعديل المستخدم',
                'status' => 1,
                'title' => 'user_edit',
            ],
            [
                'details' => 'حذف المستخدم',
                'status' => 0,
                'title' => 'user_delete',
            ],

            [
                'details' => 'عرض الصلاحيات',
                'status' => 0,
                'title' => 'role_access',
            ],
            [
                'details' => 'إنشاء صلاحية جديدة',
                'status' => 0,
                'title' => 'role_create',
            ],
            [
                'details' => 'تعديل الصلاحية',
                'status' => 0,
                'title' => 'role_edit',
            ],
            [
                'details' => 'حذف الصلاحية',
                'status' => 0,
                'title' => 'role_delete',
            ],
             //locker [
             //locker     'details' => 'الخزنة العامة',
             //locker     'status' => 1,
             //locker     'title' => 'public_treasury_access',
             //locker ],
             //locker [
             //locker     'details' => 'حذف الواردات من الخزنة العامة',
             //locker     'status' => 1,
             //locker     'title' => 'public_treasury_delete',
             //locker ],
             //locker [
             //locker     'details' => ' المالية العامة ',
             //locker     'status' => 1,
             //locker     'title' => 'financial_management_access',
             //locker ],

            // [
            //     'details' => 'عرض السنة المالية',
            //     'status' => 1,
            //     'title' => 'stage_access',
            // ],
            // [
            //     'details' => 'إنشاء سنة مالية جديدة',
            //     'status' => 1,
            //     'title' => 'stage_create',
            // ],
            // [
            //     'details' => 'تعديل السنة المالية',
            //     'status' => 1,
            //     'title' => 'stage_edit',
            // ],
            // [
            //     'details' => 'حذف السنة المالية',
            //     'status' => 1,
            //     'title' => 'stage_delete',
            // ],

            //expanse [
            //expanse     'details' => 'عرض المصروفات',
            //expanse     'status' => 1,
            //expanse     'title' => 'expanse_access',
            //expanse ],
            //expanse [
            //expanse     'details' => 'إنشاء مصروف جديد',
            //expanse     'status' => 1,
            //expanse     'title' => 'expanse_create',
            //expanse ],
            //expanse [
            //expanse     'details' => 'تعديل المصروف',
            //expanse     'status' => 1,
            //expanse     'title' => 'expanse_edit',
            //expanse ],
            //expanse [
            //expanse     'details' => 'حذف المصروف',
            //expanse     'status' => 1,
            //expanse     'title' => 'expanse_delete',
            //expanse ],

            //locker [
            //locker     'title' => 'private_locker_create',
            //locker     'details' => 'انشاء خزنة شخصية',
            //locker     'status' => 1,
            //locker ],
            //locker [
            //locker     'title' => 'private_locker_edit',
            //locker     'details' => 'تعديل  الخزنة الشخصية',
            //locker     'status' => 1,
            //locker ],
            //locker [
            //locker     'title' => 'private_locker_delete',
            //locker     'details' => ' حذف الخزنة الشخصية',
            //locker     'status' => 1,
            //locker ],
            //locker [
            //locker     'title' => 'private_locker_access',
            //locker     'details' => ' عرض الخزائن الشخصية',
            //locker     'status' => 1,
            //locker ],

            //expanse [
            //expanse     'title' => 'budget_name_create',
            //expanse     'details' => 'انشاء اسم موازنة جديدة',
            //expanse     'status' => 1,
            //expanse ],
            //expanse [
            //expanse     'title' => 'budget_name_edit',
            //expanse     'details' => 'تعديل اسم الموازنة',
            //expanse     'status' => 1,
            //expanse ],
            //expanse [
            //expanse     'title' => 'budget_name_delete',
            //expanse     'details' => ' تعديل  اسم الموازنة',
            //expanse     'status' => 1,
            //expanse ],
            //expanse [
            //expanse     'title' => 'budget_name_access',
            //expanse     'details' => ' عرض اسماء الموازنة',
            //expanse     'status' => 1,
            //expanse ],

            //expanse [
            //expanse     'details' => 'عرض الموازنة العامة',
            //expanse     'status' => 1,
            //expanse     'title' => 'budget_access',
            //expanse ],
            //expanse [
            //expanse     'details' => 'إنشاء موازنة جديدة',
            //expanse     'status' => 1,
            //expanse     'title' => 'budget_create',
            //expanse ],
            //expanse [
            //expanse     'details' => 'تعديل الموازنة',
            //expanse     'status' => 1,
            //expanse     'title' => 'budget_edit',
            //expanse ],
            //expanse [
            //expanse     'details' => 'حذف الموازنة',
            //expanse     'status' => 1,
            //expanse     'title' => 'budget_delete',
            //expanse ],

            //client [
            //client     'details' => 'عرض  العملاء',
            //client     'status' => 1,
            //client     'title' => 'client_access',
            //client ],
            //client [
            //client     'details' => 'إنشاء عميل جديد',
            //client     'status' => 1,
            //client     'title' => 'client_create',
            //client ],
            //client [
            //client     'details' => 'تعديل العميل',
            //client     'status' => 1,
            //client     'title' => 'client_edit',
            //client ],
            //client [
            //client     'details' => 'حذف العميل',
            //client     'status' => 1,
            //client     'title' => 'client_delete',
            //client ],
            //client [
            //client     'details' => 'توريد مبلغ الى العميل',
            //client     'status' => 1,
            //client     'title' => 'client_amount',
            //client ],

            //supplier [
            //supplier     'details' => 'عرض  الموردين',
            //supplier     'status' => 1,
            //supplier     'title' => 'supplier_access',
            //supplier ],
            //supplier [
            //supplier     'details' => 'إنشاء مورد جديد',
            //supplier     'status' => 1,
            //supplier     'title' => 'supplier_create',
            //supplier ],
            //supplier [
            //supplier     'details' => 'تعديل المورد',
            //supplier     'status' => 1,
            //supplier     'title' => 'supplier_edit',
            //supplier ],
            //supplier [
            //supplier     'details' => 'حذف المورد',
            //supplier     'status' => 1,
            //supplier     'title' => 'supplier_delete',
            //supplier ],
            //supplier [
            //supplier     'details' => 'توريد مبلغ الى المورد',
            //supplier     'status' => 1,
            //supplier     'title' => 'supplier_amount',
            //supplier ],

            //product[
            //product    'details' => 'إدارة المنتجات ',
            //product    'status' => 1,
            //product    'title' => 'product_management_access',
            //product],
            //product [
            //product     'details' => 'عرض المنتجات',
            //product     'status' => 1,
            //product     'title' => 'product_access',
            //product ],
            //product [
            //product     'details' => 'إنشاء منتج جديد',
            //product     'status' => 1,
            //product     'title' => 'product_create',
            //product ],
            //product [
            //product     'details' => 'تعديل المنتج',
            //product     'status' => 1,
            //product     'title' => 'product_edit',
            //product ],
            //product [
            //product     'details' => 'حذف المنتج',
            //product     'status' => 1,
            //product     'title' => 'product_delete',
            //product ],
            //product [
            //product     'details' => 'عرض أقسام المنتجات',
            //product     'status' => 1,
            //product     'title' => 'category_access',
            //product ],
            //product [
            //product     'details' => 'إنشاء قسم منتج جديدة',
            //product     'status' => 1,
            //product     'title' => 'category_create',
            //product ],
            //product [
            //product     'details' => 'تعديل قسم المنتج',
            //product     'status' => 1,
            //product     'title' => 'category_edit',
            //product ],
            //product [
            //product     'details' => 'حذف قسم المنتج',
            //product     'status' => 1,
            //product     'title' => 'category_delete',
            //product ],
            //product [
            //product     'details' => 'عرض المخازن',
            //product     'status' => 1,
            //product     'title' => 'store_access',
            //product ],
            //product [
            //product     'details' => 'إنشاء مخزن جديد',
            //product     'status' => 1,
            //product     'title' => 'store_create',
            //product ],
            //product [
            //product     'details' => 'تعديل المخزن',
            //product     'status' => 1,
            //product     'title' => 'store_edit',
            //product ],
            //product [
            //product     'details' => 'حذف المخزن',
            //product     'status' => 1,
            //product     'title' => 'store_delete',
            //product ],
            //product [
            //product     'details' => 'عرض فواتير المشتريات',
            //product     'status' => 1,
            //product     'title' => 'supplier_order_access',
            //product ],
            //product [
            //product     'details' => 'إنشاء فاتورة مشتريات',
            //product     'status' => 1,
            //product     'title' => 'supplier_order_create',
            //product ],
            //product [
            //product     'details' => ' استلام فاتورة مشتريات',
            //product     'status' => 1,
            //product     'title' => 'supplier_order_edit',
            //product ],
            //product [
            //product     'details' => 'إلغاء فاتورة المشتريات',
            //product     'status' => 1,
            //product     'title' => 'supplier_order_delete',
            //product ],
            //product [
            //product     'details' => 'عرض فواتير المبيعات',
            //product     'status' => 1,
            //product     'title' => 'order_access',
            //product ],
            //product [
            //product     'details' => 'إنشاء فاتورة مبيعات',
            //product     'status' => 1,
            //product     'title' => 'order_create',
            //product ],
            //product [
            //product     'details' => ' استلام فاتورة مبيعات',
            //product     'status' => 1,
            //product     'title' => 'order_edit',
            //product ],
            //product [
            //product     'details' => 'إلغاء فاتورة المبيعات',
            //product     'status' => 1,
            //product     'title' => 'order_delete',
            //product ],

        ];
        Permission::insert($permissions);
    }
}
