import { defineStore } from "pinia";
import items from "../../plugins/sidebar_item";
import itemsUser from "../../plugins/user_item";
import ability from "@/services/ability";
import Altawhed from "../../plugins/tawhed";

export const useSettingsItem = defineStore("item-settings", {
    state: () => ({
        items: items,
        userList: itemsUser,
        navSide: [{
            text: "لوحة التحكم",
            icon: "mdi-home-outline",
            url: "/dashboard",
        },],
        localItems: [],
        altawhed: Altawhed,
        userData: {
            id: null,
            name: null,
            email: null,
            phone: null,
            account: null,
            role: null,
            created_at: null,
        },
    }),
    getters: {
        sidebar: (state) => state.items,
        itemNav: (state) => state.navSide,

        itemSide: (state) =>
            state.localItems.filter((e) => {
                let list = state.navSide.map((e) => e.url);
                return !list.includes(e.url);
            }),
    },

    actions: {
        addItem(item) {
            this.navSide.push(item);
        },
        removeItem(index) {
            this.navSide.splice(index, 1);
        },

        setLocalItems() {
            this.localItems = [];
            this.items.filter((e) => {
                if (e.children) {
                    e.children.filter((i) => {
                        this.localItems.push(i);
                    });
                } else {
                    this.localItems.push(e);
                }
            });
        },
        getRoles() {
            axios.get("abilities").then((response) => {
                ability.update([
                    { action: response.data.data, subject: "all" },
                ]);
                this.userData = response.data.user;
            });
        },
    },
    // persist :true
});
