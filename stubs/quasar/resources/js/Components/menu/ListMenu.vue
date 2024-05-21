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
   //expanse  {
   //expanse      text: "item.expanse",
   //expanse      icon: "mdi-cash-fast",
   //expanse      to: "/expanses",
   //expanse      access: "expanse",
   //expanse  },
   //client {
   //client     text: "item.client",
   //client     icon: "mdi-account-supervisor-outline",
   //client     to: "/clients",
   //client     access: "client",
   //client },
   //supplier  {
   //supplier      text: "item.supplier",
   //supplier      icon: "mdi-home-silo",
   //supplier      to: "/suppliers",
   //supplier      access: "supplier",
   //supplier  },
   //locker  {
   //locker      to: ["/public-treasuries", "/private-lockers", "/stages", "/expanses", '/checks'],
   //locker      text: "item.financial_management",
   //locker      icon: "mdi-finance",
   //locker      access: "financial_management",
   //locker      children: [
   //locker          {
   //locker              text: "item.check",
   //locker              icon: "mdi-chart-bell-curve",
   //locker              to: "/checks",
   //locker              access: "order",
   //locker          },
   //locker          {
   //locker              text: "item.budget",
   //locker              icon: "mdi-chart-bell-curve",
   //locker              to: "/budgets",
   //locker              access: "budget",
   //locker          },
   //locker          {
   //locker              text: "item.budget_name",
   //locker              icon: "mdi-chart-bell-curve",
   //locker              to: "/budget-names",
   //locker              access: "budget_name",
   //locker          },
   //locker          {
   //locker              to: "/public-treasuries",
   //locker              text: "item.public_treasury",
   //locker              access: "public_treasury",
   //locker              icon: "mdi-door-closed-lock",
   //locker          },
   //locker          {
   //locker              text: "item.private_locker",
   //locker              to: "/private-lockers",
   //locker              access: "private_locker",
   //locker              icon: "mdi-lock-outline",
   //locker          },
   //locker          {
   //locker              to: "/stages",
   //locker              text: "item.stage",
   //locker              access: "stage",
   //locker              icon: "mdi-finance",
   //locker          },
   //locker      ],
   //locker  },
   //product  {
   //product      to: "/stores",
   //product      text: "item.store",
   //product      access: "store",
   //product      icon: "mdi-storefront-minus-outline",
   //product  },

    //product {
    //product     to: ["/categories", "/products", "/units"],
    //product     text: "item.product_management",
    //product     icon: "mdi-format-list-numbered-rtl",
    //product     access: "product_management",
    //product     children: [
    //product         {
    //product             text: "item.category",
    //product             to: "/categories",
    //product             access: "category",
    //product             icon: "mdi-tune-vertical",
    //product         },
    //product         {
    //product             to: "/products",
    //product             text: "item.product",
    //product             access: "product",
    //product             icon: "mdi-format-list-checkbox",
    //product         },
    //product         {
    //product             to: "/units",
    //product             text: "item.unit",
    //product             access: "product",
    //product             icon: "mdi-format-list-checkbox",
    //product         },
    //product     ],
    //product },

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

    //don`t remove this lint
];
</script>
