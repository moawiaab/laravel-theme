import axios from "axios";
import { defineStore } from "pinia";
import { useSinglePermissions } from "./single";
import { useSetting } from "../settings/SettingIndex";
import { useSettingAlert } from "../settings/SettingAlert";

const route = "permissions";
export const usePermissions = defineStore("index-permissions", {
    state: () => ({
        theme: useSetting().theme,
        permissions: [],
        total: 0,
        page: 1,
        query: {
            sortBy: "id",
            sortType: "desc",
            rowsPerPage: 20,
            page: 1,
        },
        loading: false,
        filters: { s: "", trashed: "" },
        showDeleted: false,
        itemId: null,
        itemsSelected: [],
        trashed: false,
    }),
    getters: {
        // items: (state) => state.permissions,
        // totalItem: (state) => state.total,
    },
    actions: {
        fetchIndexData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .get(route, { params: { ...this.filters, ...this.query } })
                    .then((response) => {
                        this.permissions = response.data.data;
                        this.total = response.data.meta.total;
                        this.page = response.data.meta.current_page;
                    })
                    .catch((error) => {})
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
        setQuery(q) {
            this.query = q;
        },
        setFilters(q) {
            this.filters = q;
        },
        editItem(item) {
            const permissions = useSinglePermissions();
            permissions.showModalEdit = true;
            permissions.fetchEditData(item.id);
        },
        showItem(item) {
            const permissions = useSinglePermissions();
            permissions.showModalShow = true;
            permissions.fetchShowData(item.id);
        },
        showDeletedMethod(item, trash = false) {
            this.itemId = item;
            this.showDeleted = true;
            this.trashed = trash;
        },
        deleteItem() {
            axios
                .delete(`${route}/${this.itemId}`)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم حذف الإذن بنجاح",
                        "success",
                        true
                    );
                    this.showDeleted = false;
                    this.fetchIndexData();
                    this.itemId = null;
                })
                .catch((error) => {
                    useSettingAlert().setAlert(
                        error.response.data.message,
                        "warning",
                        true
                    );
                });
        },

        deleteAllItem(items) {
            const item = { items: items.map((e) => e.id) };
            console.log(item);
            axios
                .post(`${route}/delete-all`, item)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم حذف جميع الأذونات المختارة بنجاح",
                        "success",
                        true
                    );
                    this.showDeleted = false;
                    this.fetchIndexData();
                    this.itemId = null;
                })
                .catch((error) => {
                    useSettingAlert().setAlert(
                        error.response.data.message,
                        "warning",
                        true
                    );
                });
        },

        deleteTrash() {
            axios
                .put(`${route}/${this.itemId}/delete-restore`)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم حذف الإذن من سلة المحذوفات بنجاح",
                        "success",
                        true
                    );
                    this.showDeleted = false;
                    this.fetchIndexData();
                    this.itemId = null;
                })
                .catch((error) => {
                    useSettingAlert().setAlert(
                        error.response.data.message,
                        "warning",
                        true
                    );
                });
        },

        restoreItem(item) {
            axios
                .put(`${route}/${item}/restore`)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم ارجاع الإذن بنجاح",
                        "success",
                        true
                    );
                    this.showDeleted = false;
                    this.fetchIndexData();
                    this.itemId = null;
                })
                .catch((error) => {
                    useSettingAlert().setAlert(
                        error.response.data.message,
                        "warning",
                        true
                    );
                });
        },
    },
});
