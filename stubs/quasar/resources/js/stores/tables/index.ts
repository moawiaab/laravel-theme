import axios from "axios";
import { defineStore } from "pinia";
import { Notify } from 'quasar'

export const useTables = defineStore("auth-tables", {
    state: () => ({
        entry: [],
        links: {},
        meta: {},
        row: {},
        newRow: false,
        editRow: false,
        showRow: false,
        confirm: false,
        outPage : false,
        splitterModel: 50,
        filters: { s: "", sortBy: "id", trashed: '', type: 1 },
        pagination: {
            sortType: "desc",
            descending: false,
            page: 1,
            rowsPerPage: 15,
            rowsNumber: 0,
        },
        query: {
            page: 1,
        },
        loading: false,
        selected: [],
        visibleColumns: [],
        router: <String><unknown>"",
        trashedData: [
            { name: "table.d", id: "" },
            { name: "table.only", id: "only" },
            { name: "table.with", id: "with" },
        ]
    }),
    getters: {
        data: (state) => state.entry,
    },

    actions: {
        async getData() {
            try {
                this.loading = true;
                await axios.get(this.router?.toString(), { params: { ...this.filters, ...this.pagination } }).then((data) => {
                    this.entry = data.data.data
                    this.pagination = {
                        ...this.pagination, ...{
                            page: data.data.meta.current_page,
                            rowsPerPage: data.data.meta.per_page,
                            rowsNumber: data.data.meta.total
                        }
                    }

                })
            } catch (error) {

            }
            this.loading = false
        },
        setFilter(filter: string) {
            this.filters.s = filter
        },

        setRouter(text: String) {
            this.router = text
        },
        getSelected() {
            console.log(this.selected)
        },

        editItem(item: any) {
            this.row = item
            this.editRow = true
        },

        showItem(item: any) {
            this.row = item
            this.showRow = true
        },

        delete(id: number) {
            axios
                .delete(`${this.router}/${id}`)
                .then((response) => {
                    Notify.create({
                        message: 'تم الحذف بنجاح!',
                        type: 'positive',

                    })
                    this.getData();
                    this.confirm = false;
                    this.row = {};
                })
                .catch((error) => {
                    Notify.create({
                        message: error.response.data.message || "",
                        type: "warning"
                    })
                });
        },

        restoreItem(id: number) {
            axios
                .put(`${this.router}/${id}/restore`)
                .then((response) => {
                    Notify.create({
                        message: "تم الارجاع  بنجاح",
                        type: 'positive',


                    })
                    this.getData();
                    this.confirm = false;
                    this.row = {};
                })
                .catch((error) => {
                    Notify.create({
                        message: error.response.data.message || "",
                        type: "warning"
                    })
                });
        },

        toggleItem(id: number) {
            axios
                .put(`${this.router}/${id}/toggle`)
                .then((response) => {
                    Notify.create({
                        message: "تم تغير الحالة بنجاح",
                        type: 'positive',
                    })
                    this.getData();
                })
                .catch((error) => {
                    Notify.create({
                        message: error.response.data.message || "",
                        type: "warning"
                    })
                });
        }

    },
});
