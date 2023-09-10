import axios from "axios";
import { defineStore } from "pinia";
import { usePageIndex } from "../pages/pageIndex";
import { useSettingAlert } from "../settings/SettingAlert";
const route = "users";

export const useUserIndex = defineStore("index-users", {
    state: () => ({
        data: { amount: 0 },
        loading: false,
        userId: <null | number>null,
        dialog: false,
    }),
    actions: {
        sendLocker() {
            this.loading = true;
            axios
                .put(`${route}/${this.userId}/locker`, this.data)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم إنشاء خزنة جديد بنجاح",
                        "success",
                        true
                    );
                    // this.showDeleted = false;
                    usePageIndex().fetchIndexData();
                    this.dialog = false;
                    this.userId = null;
                })
                .catch((error) => {
                    useSettingAlert().setAlert(
                        error.response.data.message,
                        "warning",
                        true
                    );
                });
            this.loading = false;
        },
        setId(id: number) {
            this.userId = id;
        },
    },
});
