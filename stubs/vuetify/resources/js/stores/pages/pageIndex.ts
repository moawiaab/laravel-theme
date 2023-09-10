import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { useSetting } from "../settings/SettingIndex";
import { useSinglePage } from "./pageSingle";

export const usePageIndex = defineStore("index-pages", {
    state: () => ({
        theme: useSetting().theme,
        data: [],
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
        route: "",
        alertMessage: String,
        table: "",
    }),
    getters: {
        // items: (state) => state.data,
        // totalItem: (state) => state.total,
    },
    actions: {
        fetchIndexData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .get(this.route.toString(), {
                        params: { ...this.filters, ...this.query },
                    })
                    .then((response) => {
                        this.data = response.data.data;
                        this.total = response.data.meta.total;
                        this.page = response.data.meta.current_page;
                    })
                    .catch((error) => {});
                this.loading = false;
            });
        },
        setQuery(q: any) {
            this.query = q;
        },
        setFilters(q: any) {
            this.filters = q;
        },
        editItem(item: any) {
            const single = useSinglePage();
            single.showModalEdit = true;
            single.fetchEditData(item);
        },
        showItem(item: any) {
            const single = useSinglePage();
            single.showModalShow = true;
            single.fetchShowData(item.id);
        },
        showDeletedMethod(item: any, trash = false) {
            this.itemId = item;
            this.showDeleted = true;
            this.trashed = trash;
        },
        deleteItem() {
            axios
                .delete(`${this.route}/${this.itemId}`)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم الحذف بنجاح",
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

        deleteAllItem(items: any) {
            const item = {
                items: items.map((e: any) => {
                    if (e.deletable) {
                        return e.id;
                    }
                }),
            };
            axios
                .post(`${this.route}/delete-all`, item)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم حذف الجميع بنجاح",
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
        restoreItem(item: Number) {
            axios
                .put(`${this.route}/${item}/restore`)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم الارجاع  بنجاح",
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

        toggleItem(item: Number) {
            axios
                .put(`${this.route}/${item}/toggle`)
                .then((response) => {
                    useSettingAlert().setAlert(
                        "تم تغيير الحالة  بنجاح",
                        "success",
                        true
                    );
                    this.fetchIndexData();
                })
                .catch((error) => {
                    useSettingAlert().setAlert(
                        error.response.data.message,
                        "warning",
                        true
                    );
                });
        },

        setup(route: string) {
            useSinglePage().$reset();
            this.route = route;
            this.table = route;
            useSinglePage().setRoute(route);
            useSinglePage().fetchCreateData();
        },
    },
});
