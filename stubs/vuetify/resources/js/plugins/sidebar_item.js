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
        text: "item.development1",
        icon: "mdi-wrench-cog",
        url: "/development",
        access: "development",
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

    //don`t remove this lint
];

export default items;
