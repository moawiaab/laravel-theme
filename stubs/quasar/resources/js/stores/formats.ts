import { Notify } from "quasar";
import axios from "axios";
import { defineStore } from "pinia";

export const useFormats = defineStore("formats-data-store", {
    state: () => ({
        entry: {},
        textLengths: 30,
        optionType: false,
        optionTypeLast: false,
        optionTypeFirst: false,
        rowNum: 15,
    }),
    getters: {
        // columns: () => Users,
    },
    actions: {
        async setPassword() {
            this.loading = true;
            await axios
                .post("users/password", this.entry)
                .then((response) => {
                    Notify.create({
                        message: "تم إضافة المستخدم بنجاح",
                        type: "positive",
                    });
                    this.$reset();
                })
                .catch((error) => {
                    this.errors = error.response.data.errors || this.errors;
                    Notify.create({
                        message: error.response.data.message,
                        type: "warning",
                    });
                    this.loading = false;
                });
        },
    },
    persist: true,
});
