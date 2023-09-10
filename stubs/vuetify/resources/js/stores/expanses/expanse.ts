import axios from "axios";
import { defineStore } from "pinia";
import { usePageIndex } from "../pages/pageIndex";
import { useSettingAlert } from "../settings/SettingAlert";
const route = "expanses";

export const useExpansesIndex = defineStore("index-expanses", {
    state: () => ({
        data: { amount: null, details: "" },
        loading: false,
        userId: null,
        dialog: false,
    }),
    actions: {
        sendAmount() {
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
        setId(id: Number) {
            this.userId = id;
        },
    },
});
