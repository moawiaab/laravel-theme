import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { useSetting } from "../settings/SettingIndex";
import { useSingleRoles } from "./single";

const route = "roles";
export const useRoles = defineStore("roles-index", {
    state: () => ({
        theme: useSetting().theme,
        roles: [],
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
        // items: (state) => state.roles,
        // totalItem: (state) => state.total,
    },
    actions: {
        fetchIndexData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .get(route, { params: { ...this.filters, ...this.query } })
                    .then((response) => {
                        this.roles = response.data.data;
                        this.total = response.data.meta.total;
                        this.page = response.data.meta.current_page;
                    })
                    .catch((error) => {})
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
        setQuery(q:any) {
            this.query = q;
        },
        setFilters(q:any) {
            this.filters = q;
        },
        editItem(item:any) {
            const roles = useSingleRoles();
            roles.showModalEdit = true;
            roles.fetchEditData(item.id);
        },
        showItem(item :any) {
            const roles = useSingleRoles();
            roles.showModalShow = true;
            roles.fetchShowData(item.id);
        },
        showDeletedMethod(item:any, trash = false) {
            this.itemId = item;
            this.showDeleted = true;
            this.trashed = trash;
        },
        deleteItem() {
            axios
                .delete(`${route}/${this.itemId}`)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم حذف الصلاحية بنجاح",
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

        deleteAllItem(items:any) {
            const item = { items: items.map((e:any) => e.id) };
            console.log(item);
            axios
                .post(`${route}/delete-all`, item)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم حذف جميع الصلاحيات المختارة بنجاح",
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
        restoreItem(item:Number) {
            axios
                .put(`${route}/${item}/restore`)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم ارجاع الصلاحية بنجاح",
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
