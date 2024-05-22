<template>
    <template v-for="(item, index) in items" :key="index">
        <list-item
            v-if="item.children && auth.can.includes(`${item.access}_access`)"
            :label="$t(item.text)"
            :icon="item.icon"
            :default-opened="item.to.includes($route.path)"
        >
            <template v-for="(i, id) in item.children" :key="id">
                <item
                    v-if="auth.can.includes(`${i.access}_access`)"
                    :data="i"
                />
            </template>
        </list-item>
        <template v-else>
            <item
                v-if="auth.can.includes(`${item.access}_access`)"
                :data="item"
            />
        </template>
    </template>
</template>

<script setup lang="ts">
import Item from "./Item.vue";
import ListItem from "./ListItem.vue";
import { useAuth } from "@/stores/auth/index";

const auth = useAuth();

const items = [
    {
        text: "g.dashboard",
        icon: "mdi-home-outline",
        to: "/",
        access: "dashboard",
    },

    {
        to: ["/development", "/development-create", "/development-tools"],
        text: "item.development",
        icon: "mdi-cog-sync",
        access: "development",
        children: [
            {
                text: "item.development1",
                icon: "mdi-wrench-cog",
                to: "/development",
                access: "development",
            },
            {
                text: "item.development2",
                icon: "mdi-shape-plus",
                to: "/development-create",
                access: "development",
            },
            {
                text: "item.development3",
                icon: "mdi-cog-transfer",
                to: "/development-tools",
                access: "development",
            },


        ],
    },

    {
        text: "item.account",
        icon: "mdi-source-branch",
        to: "/accounts",
        access: "account",
    },
     {
         text: "item.expanse",
         icon: "mdi-cash-fast",
         to: "/expanses",
         access: "expanse",
     },
    {
        text: "item.client",
        icon: "mdi-account-supervisor-outline",
        to: "/clients",
        access: "client",
    },
     {
         text: "item.supplier",
         icon: "mdi-home-silo",
         to: "/suppliers",
         access: "supplier",
     },
     {
         to: ["/public-treasuries", "/private-lockers", "/stages", "/expanses", '/checks'],
         text: "item.financial_management",
         icon: "mdi-finance",
         access: "financial_management",
         children: [
             {
                 text: "item.check",
                 icon: "mdi-chart-bell-curve",
                 to: "/checks",
                 access: "order",
             },
             {
                 text: "item.budget",
                 icon: "mdi-chart-bell-curve",
                 to: "/budgets",
                 access: "budget",
             },
             {
                 text: "item.budget_name",
                 icon: "mdi-chart-bell-curve",
                 to: "/budget-names",
                 access: "budget_name",
             },
             {
                 to: "/public-treasuries",
                 text: "item.public_treasury",
                 access: "public_treasury",
                 icon: "mdi-door-closed-lock",
             },
             {
                 text: "item.private_locker",
                 to: "/private-lockers",
                 access: "private_locker",
                 icon: "mdi-lock-outline",
             },
             {
                 to: "/stages",
                 text: "item.stage",
                 access: "stage",
                 icon: "mdi-finance",
             },
         ],
     },
     {
         to: "/stores",
         text: "item.store",
         access: "store",
         icon: "mdi-storefront-minus-outline",
     },

     {
         to: ["/categories", "/products", "/units"],
         text: "item.product_management",
         icon: "mdi-format-list-numbered-rtl",
         access: "product_management",
         children: [
             {
                 text: "item.category",
                 to: "/categories",
                 access: "category",
                 icon: "mdi-tune-vertical",
             },
             {
                 to: "/products",
                 text: "item.product",
                 access: "product",
                 icon: "mdi-format-list-checkbox",
             },
             {
                 to: "/units",
                 text: "item.unit",
                 access: "product",
                 icon: "mdi-format-list-checkbox",
             },
         ],
     },

    {
        text: "item.user_management",
        icon: "mdi-account-cog-outline",
        to: ["/users", "/roles", "/permissions"],
        access: "user_management",
        children: [
            {
                text: "item.user",
                icon: "mdi-account-details-outline",
                to: "/users",
                access: "user",
            },
            {
                text: "item.role",
                icon: "mdi-account-lock-outline",
                to: "/roles",
                access: "role",
            },
            {
                text: "item.permission",
                icon: "mdi-lock-outline",
                to: "/permissions",
                access: "permission",
            },
        ],
    },

   
{
            text: "item.donor",
            icon: "list",
            to: "/donors",
            access: "donor",
        },
 
{
            text: "item.test",
            icon: "list",
            to: "/tests",
            access: "test",
        },
 //don`t remove this lint
];
</script>
