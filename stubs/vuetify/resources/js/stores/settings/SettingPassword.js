import { defineStore } from "pinia";
import axios from "axios";
import { useSettingAlert } from "./SettingAlert";

export const useSettingPassword = defineStore("settings-password", {
    state: () => ({
        showPassword: false,
        password: {
            password: "",
            newPassword: "",
            newPassword_confirmation: "",
        },
        rules: {
            password: [(val) => val < 10 || `I don't believe you!`],
            required: [
                (val) =>
                    (val || "").length > 0 ||
                    "لا تترك هذا الحقل فارغاً لو سمحت",
            ],
        },
        loading: false,
        errors: {
            password: "",
            newPassword: "",
        },
        alert: "",
    }),

    actions: {
        userMenuClicked(item) {
            if (item.model == "password") this.showPassword = true;
        },

        changePassword() {
            const alertData = useSettingAlert();
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post("users/password", this.password)
                    .then((response) => {
                        alertData.setAlert(
                            "تم تغيير كلمة السر بنجاح",
                            "success",
                            true
                        );
                        resolve(response);
                    })
                    .catch((error) => {
                        this.alert = error?.response?.data?.message || this.alert;
                        alertData.setAlert(this.alert, "error", true);
                        this.errors = error.response.data.errors || this.errors;
                        reject(error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
    },
});
