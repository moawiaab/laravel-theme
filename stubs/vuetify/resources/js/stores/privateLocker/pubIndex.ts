import axios from "axios";
import { defineStore } from "pinia";
import { usePageIndex } from "../pages/pageIndex";
import { useSettingAlert } from "../settings/SettingAlert";
import { useSettingsItem } from "../settings/SettingItem";
const route = "public-treasuries";
interface entryData {
    id: Number | null;
    take_amount: String;
    add_amount: String;
    amount: String;
    name: String;
}
export const usePublicLocker = defineStore("index-public-locker", {
    state: () => ({
        data: {
            pub: <entryData>{},
            expanses: [],
            pubItems: [],
        },
        entey : {
            amount : null,
            details : ''
        },
        loading: false,
        itemId: null,
        dialog: false,
    }),
    actions: {
        fetchShowData() {
            this.loading = true;
            axios
                .get(`${route}/show-data/${useSettingsItem().userData.account}`)
                .then((response) => {
                    this.data = response.data;
                })
                .catch((error) => {})
                .finally(() => (this.loading = false));
        },

        doneData(item : Number) {
            this.loading = true;
            axios
                .put(`${route}/${item}/done`)
                .then((response) => {
                    usePageIndex().fetchIndexData();
                    this.fetchShowData();
                    useSettingAlert().setAlert('تم استلام المبلغ بنجاح','success',true);
                })
                .catch((error) => {})
                .finally(() => (this.loading = false));
        },

        deleteItem() {
            axios
                .delete(`${route}/${this.itemId}`, this.entey)
                .then((response) => {
                    usePageIndex().fetchIndexData();
                    this.fetchShowData();
                    useSettingAlert().setAlert('تم ارجاع المبلغ الى الخزنة الشخصية بنجاح','success',true);
                    this.itemId = null;
                    this.dialog = false;
                })
                .catch((error) => {
                    useSettingAlert().setAlert(
                        error.response.data.message,
                        "warning",
                        true
                    );
                });
        },

        setId(id: Number) {
            this.itemId = id;
        },
    },
});
