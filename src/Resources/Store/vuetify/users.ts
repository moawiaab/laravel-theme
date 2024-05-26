import axios from "axios";
import { defineStore } from "pinia";
const route = "users";

export const useUserIndex = defineStore("index-users", {
    state: () => ({
        data: { amount: 0 },
        loading: false,
        userId: <null | number>null,
        dialog: false,
    }),
    actions: {

    },
});
