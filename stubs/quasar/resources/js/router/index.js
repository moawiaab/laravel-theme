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
            {
                path: "budget-names",
                name: " اسماء الموازنة",
                component: () => import("@/Pages/FinancialManagement/budget-names/index.vue"),
            },
            {
                path: "budgets",
                name: "الموازنة",
                component: () => import("@/Pages/FinancialManagement/budgets/index.vue"),
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
                path: "public-treasuries",
                name: "الخزنة العامة",
                component: () => import("@/Pages/FinancialManagement/public-treasuries/index.vue"),
            },

            {
                path: "private-lockers",
                name: "الخزنة الشخصية",
                component: () => import("@/Pages/FinancialManagement/private-lockers/index.vue"),
            },

            {
                path: "expanses",
                name: "المصروفات",
                component: () => import("@/Pages/expanses/index.vue"),
            },


            {
                path: "stages",
                name: "الشجرة المالية",
                component: () => import("@/Pages/FinancialManagement/stages/index.vue"),
            },

            {
                path: "settings",
                name: "اعدادات النظام",
                component: () => import("@/Pages/settings/index.vue"),
            },


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
