import axios from "axios";
import { defineStore } from "pinia";
import { usePageIndex } from "../pages/pageIndex";
import { useSettingAlert } from "../settings/SettingAlert";
const route = "private-lockers";

export const useUserPrivate = defineStore("index-private", {
    state: () => ({
        data: { amount: 0, details: "" },
        loading: false,
        userId: null,
        dialog: false,
        localData: {
            amount: 0,
            name: "",
            lockerId: 0,
        },
    }),
    actions: {
        sendLocker() {
            this.loading = true;
            axios
                .put(`${route}/${this.userId}/amount`, this.data)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم إنشاء خزنة جديد بنجاح",
                        "success",
                        true
                    );
                    this.showDeleted = false;
                    usePageIndex().fetchIndexData();
                    this.dialog = false;
                    this.userId = null;
                    this.$reset();
                })
                .catch((error) => {
                    useSettingAlert().setAlert(
                        error.response.data.message,
                        "warning",
                        true
                    );
                })
                .finally(() => (this.loading = false));
        },
        setId(id: any) {
            this.userId = id.id;
            this.localData = id;
        },
    },
});
