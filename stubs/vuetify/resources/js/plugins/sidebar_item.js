const items = [
    {
        text: "g.dashboard",
        icon: "mdi-home-outline",
        url: "/",
        access: "dashboard",
    },
    {
        text: "item.account",
        icon: "mdi-source-branch",
        url: "/accounts",
        access: "account",
    },
    {
        text: "item.expanse",
        icon: "mdi-cash-fast",
        url: "/expanses",
        access: "expanse",
    },
    {
        text: "item.client",
        icon: "mdi-account-supervisor-outline",
        url: "/clients",
        access: "client",
    },
    {
        text: "item.supplier",
        icon: "mdi-home-silo",
        url: "/suppliers",
        access: "supplier",
    },
    {
        url: [
            "/public-treasuries",
            "/private-lockers",
            "/stages",
            "/expanses",
            "/checks",
        ],
        text: "item.financial_management",
        icon: "mdi-finance",
        access: "financial_management",
        children: [
            {
                text: "item.check",
                icon: "mdi-chart-bell-curve",
                url: "/checks",
                access: "order",
            },
            {
                text: "item.budget",
                icon: "mdi-chart-bell-curve",
                url: "/budgets",
                access: "budget",
            },
            {
                text: "item.budget_name",
                icon: "mdi-chart-bell-curve",
                url: "/budget-names",
                access: "budget_name",
            },
            {
                url: "/public-treasuries",
                text: "item.public_treasury",
                access: "public_treasury",
                icon: "mdi-door-closed-lock",
            },
            {
                text: "item.private_locker",
                url: "/private-lockers",
                access: "private_locker",
                icon: "mdi-lock-outline",
            },
            {
                url: "/stages",
                text: "item.stage",
                access: "stage",
                icon: "mdi-finance",
            },
        ],
    },
    {
        url: "/stores",
        text: "item.store",
        access: "store",
        icon: "mdi-storefront-minus-outline",
    },
    {
        url: ["/orders", "/supplier-orders", "/order-backs"],
        text: "item.order_management",
        icon: "mdi-cart-check",
        access: "product_management",
        children: [
            {
                url: "/orders",
                text: "item.order",
                access: "order",
                icon: "mdi-cart-variant",
            },
            {
                text: "item.supplier_order",
                url: "/supplier-orders",
                access: "supplier_order",
                icon: "mdi-cart-arrow-down",
            },
            {
                text: "item.back",
                url: "/orders/backs",
                access: "order",
                icon: "mdi-backup-restore",
            },
        ],
    },
    {
        url: ["/categories", "/products", "/units"],
        text: "item.product_management",
        icon: "mdi-format-list-numbered-rtl",
        access: "product_management",
        children: [
            {
                text: "item.category",
                url: "/categories",
                access: "category",
                icon: "mdi-tune-vertical",
            },
            {
                url: "/products",
                text: "item.product",
                access: "product",
                icon: "mdi-format-list-checkbox",
            },
            {
                url: "/units",
                text: "item.unit",
                access: "product",
                icon: "mdi-format-list-checkbox",
            },
        ],
    },

    {
        text: "item.user_management",
        icon: "mdi-account-cog-outline",
        url: ["/users", "/roles", "/permissions"],
        access: "user_management",
        children: [
            {
                text: "item.user",
                icon: "mdi-account-details-outline",
                url: "/users",
                access: "user",
            },
            {
                text: "item.role",
                icon: "mdi-account-lock-outline",
                url: "/roles",
                access: "role",
            },
            {
                text: "item.permission",
                icon: "mdi-lock-outline",
                url: "/permissions",
                access: "permission",
            },
        ],
    },
    {
        url: ["/reports", "/reports/users"],
        text: "item.report",
        access: "store",
        icon: "mdi-chart-bell-curve",
        children: [
            {
                text: "item.report1",
                icon: "mdi-hand-coin-outline",
                url: "/reports/users",
                access: "account",
            },
            {
                text: "item.report2",
                icon: "mdi-finance",
                url: "/reports",
                access: "account",
            },
        ],
    },
];

export default items;
