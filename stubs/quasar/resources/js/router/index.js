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
                path: "development",
                name: " development",
                component: () => import("@/Pages/Development/Index.vue"),
            },
            {
                path: "development-create",
                name: " development create",
                component: () => import("@/Pages/Development/Create.vue"),
            },
            {
                path: "development-tools",
                name: " development tools",
                component: () => import("@/Pages/Development/Tool.vue"),
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
            //locker {
            //locker     path: "budget-names",
            //locker     name: " اسماء الموازنة",
            //locker     component: () => import("@/Pages/FinancialManagement/budget-names/index.vue"),
            //locker },
            //locker {
            //locker     path: "budgets",
            //locker     name: "الموازنة",
            //locker     component: () => import("@/Pages/FinancialManagement/budgets/index.vue"),
            //locker },

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

            //product  {
            //product      path: "categories",
            //product      name: "أقسام المنتجات",
            //product      component: () => import("@/Pages/ProductManagement/categories/index.vue"),
            //product  },

            //client  {
            //client      path: "clients",
            //client      name: "العملاء",
            //client      component: () => import("@/Pages/clients/index.vue"),
            //client  },
            //client
            //client  {
            //client      path: "clients/:id/amounts/:name",
            //client      name: "توردات العميل",
            //client      component: () => import("@/Pages/clients/amountList.vue"),
            //client  },

            //supplier  {
            //supplier      path: "suppliers",
            //supplier      name: "الموردين",
            //supplier      component: () => import("@/Pages/suppliers/index.vue"),
            //supplier  },
            //supplier
            //supplier  {
            //supplier      path: "suppliers/:id/amounts/:name",
            //supplier      name: "توردات المورد",
            //supplier      component: () => import("@/Pages/suppliers/amountList.vue"),
            //supplier  },

            //locker {
            //locker     path: "public-treasuries",
            //locker     name: "الخزنة العامة",
            //locker     component: () => import("@/Pages/FinancialManagement/public-treasuries/index.vue"),
            //locker },
            //locker
            //locker {
            //locker     path: "private-lockers",
            //locker     name: "الخزنة الشخصية",
            //locker     component: () => import("@/Pages/FinancialManagement/private-lockers/index.vue"),
            //locker },

            //expanse  {
            //expanse      path: "expanses",
            //expanse      name: "المصروفات",
            //expanse      component: () => import("@/Pages/expanses/index.vue"),
            //expanse  },

            //product {
            //product     path: "products",
            //product     name: "المنتجات",
            //product     component: () => import("@/Pages/ProductManagement/products/index.vue"),
            //product },
            //product
            //product {
            //product     path: "units",
            //product     name: "وحدات المنتجات",
            //product     component: () => import("@/Pages/ProductManagement/units/index.vue"),
            //product },
            //product
            //product {
            //product     path: "stores",
            //product     name: "مخازن المنتجات",
            //product     component: () => import("@/Pages/ProductManagement/stores/index.vue"),
            //product },

            //locker  {
            //locker      path: "stages",
            //locker      name: "الشجرة المالية",
            //locker      component: () => import("@/Pages/FinancialManagement/stages/index.vue"),
            //locker  },

            {
                path: "settings",
                name: "اعدادات النظام",
                component: () => import("@/Pages/settings/index.vue"),
            },
            //locker  {
            //locker      path: "checks",
            //locker      name: " الشيكات",
            //locker      component: () => import("@/Pages/FinancialManagement/check/index.vue"),
            //locker  },

            //don`t remove this lint
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
