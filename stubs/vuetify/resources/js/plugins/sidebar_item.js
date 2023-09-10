const items = [
    {
        text: "لوحة التحكم",
        icon: "mdi-home-outline",
        url: "/dashboard",
        access: "dashboard",
    },
    {
        text: "الفروع",
        icon: "mdi-source-branch",
        url: "/accounts",
        access: "account",
    },
    {
        url: ["/public-treasuries", "/private-lockers", "/stages", "expanses"],
        text: "المالية العامة",
        icon: "mdi-finance",
        access: "financial_management",
        children: [
            {
                url: "/public-treasuries",
                text: "الخزنة العامة",
                access: "public_treasury",
                icon: "mdi-door-closed-lock",
            },
            {
                text: "الخزانات الشخصية",
                url: "/private-lockers",
                access: "private_locker",
                icon: "mdi-lock-outline",
            },
            {
                url: "/stages",
                text: "السنة المالية",
                access: "stage",
                icon: "mdi-finance",
            },
            {
                text: "اسماء الموازنة",
                icon: "mdi-chart-bell-curve",
                url: "/budget-names",
                access: "budget_name",
            },
            {
                text: "الموازنة",
                icon: "mdi-chart-bell-curve",
                url: "/budgets",
                access: "budget",
            },


        ],
    },
    {
        text: "المستخدمين",
        icon: "mdi-account-cog-outline",
        url: ["/users", "/roles", "/permissions"],
        access: "user_management",
        children: [
            {
                text: "المستخدمين",
                icon: "mdi-account-details-outline",
                url: "/users",
                access: "user",
            },
            {
                text: "الصلاحيات",
                icon: "mdi-account-lock-outline",
                url: "/roles",
                access: "role",
            },
            {
                text: "الأذونات",
                icon: "mdi-lock-outline",
                url: "/permissions",
                access: "permission",
            },
        ],
    },
];

export default items;
