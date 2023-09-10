import { defineStore } from "pinia";

export const useSettingAlert = defineStore("setting-alert", {
    state: () => ({
        color: "success",
        snackbar: false,
        alert: "",
    }),

    actions: {
        setAlert(alert : string, color : string, snackbar : boolean) {
            this.alert = alert;
            this.snackbar = snackbar;
            this.color = color;
        },
    },
});
