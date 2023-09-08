import { createRouter, createWebHistory } from "vue-router";
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import LoginLayout from "@/Layouts/LoginLayout.vue";

const routes = [
    {
        path: "/",
        name: "Home",
        component: DefaultLayout,
        redirect: "/dashboard",
        children: [

            {
                path: "dashboard",
                name: "لوحة التحكم",
                component: () => import("@/Pages/Dashboard.vue"),
            },
            {
                path: "users",
                name: " المستخدمين",
                component: () => import("@/Pages/Users/Index.vue"),
            },
            {
                path: "accounts",
                name: "الفروع",
                component: () => import("@/Pages/accounts/index.vue"),
            },
            {
                path: "budget-names",
                name: " اسماء الموازنة",
                component: () => import("@/Pages/budget-names/index.vue"),
            },
            {
                path: "budgets",
                name: "الموازنة",
                component: () => import("@/Pages/budgets/index.vue"),
            },

            {
                path: "roles",
                name: " الصلاحيات",
                component: () => import("@/Pages/Roles/Index.vue"),
            },
            {
                path: "permissions",
                name: "الأذونات",
                component: () => import("@/Pages/Permissions/Index.vue"),
            },

            {
                path: "categories",
                name: "أقسام المنتجات",
                component: () => import("@/Pages/categories/index.vue"),
            },

            {
                path: "clients",
                name: "العملاء",
                component: () => import("@/Pages/clients/index.vue"),
            },

            {
                path: "clients/:id/amounts/:name",
                name: "توردات العميل",
                component: () => import("@/Pages/clients/amountList.vue"),
            },

            {
                path: "suppliers",
                name: "الموردين",
                component: () => import("@/Pages/suppliers/index.vue"),
            },

            {
                path: "suppliers/:id/amounts/:name",
                name: "توردات المورد",
                component: () => import("@/Pages/suppliers/amountList.vue"),
            },

            {
                path: "public-treasuries",
                name: "الخزنة العامة",
                component: () => import("@/Pages/public-treasuries/index.vue"),
            },

            {
                path: "private-lockers",
                name: "الخزنة الشخصية",
                component: () => import("@/Pages/private-lockers/index.vue"),
            },

            // {
            //     path: "tutorials/details/:id",
            //     name: "تفاصيل الدروس",
            //     component: () => import("@/Pages/Tutorials/Details.vue"),
            // },

            {
                path: "expanses",
                name: "المصروفات",
                component: () => import("@/Pages/expanses/index.vue"),
            },

            {
                path: "products",
                name: "المنتجات",
                component: () => import("@/Pages/products/index.vue"),
            },

            {
                path: "units",
                name: "وحدات المنتجات",
                component: () => import("@/Pages/units/index.vue"),
            },

            {
                path: "stores",
                name: "مخازن المنتجات",
                component: () => import("@/Pages/stores/index.vue"),
            },

            {
                path: "orders",
                name: "فواتير المبيعات",
                component: () => import("@/Pages/orders/index.vue"),
            },
            {
                path: "orders/backs",
                name: "المرتجعات",
                component: () => import("@/Pages/orders/backs.vue"),
            },
            {
                path: "orders/create",
                name: " إنشاء فاتورة المبيعات",
                component: () => import("@/Pages/orders/create.vue"),
            },

            {
                path: "supplier-orders",
                name: "فواتير المشتريات",
                component: () => import("@/Pages/supplier-orders/index.vue"),
            },
            {
                path: "supplier-orders/create",
                name: "فواتير المشتريات جديدة",
                component: () => import("@/Pages/supplier-orders/create.vue"),
            },
            {
                path: "reports",
                name: "تقارير الارباح",
                component: () => import("@/Pages/reports/index.vue"),
            },

            {
                path: "reports/users",
                name: "تقارير المعاملات للمستخدمين",
                component: () => import("@/Pages/reports/users.vue"),
            },

            {
                path: "stages",
                name: "الشجرة المالية",
                component: () => import("@/Pages/stages/index.vue"),
            },

            {
                path: "settings",
                name: "اعدادات النظام",
                component: () => import("@/Pages/settings/index.vue"),
            },
            {
                path: "checks",
                name: " الشيكات",
                component: () => import("@/Pages/check/index.vue"),
            },
        ],
    },
    {
        path: "/auth",
        name: "Login Layout",
        component: LoginLayout,
        redirect: "/login",
        children: [
            {
                path: "/login",
                name: "Login",
                component: () => import("@/Pages/Auth/Login.vue"),
            },
            {
                path: "/register",
                name: "Register",
                component: () => import("@/Pages/Auth/Register.vue"),
            },
        ],
    },
    {
        path: "/:catchAll(.*)*",
        component: () => import("@/Pages/ErrorNotFound.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.afterEach((to, from) => {
    // console.log(to, from);
})
export default router;
