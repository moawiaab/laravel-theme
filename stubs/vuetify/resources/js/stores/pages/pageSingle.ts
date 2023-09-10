import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";

interface ListType {
    budgets: Array<[]>;
}
export const useSinglePage = defineStore("single-pages", {
    state: () => ({
        entry: {},
        lists: <ListType>{},
        showModalCreate: false,
        showModalEdit: false,
        showModalShow: false,
        route: "",
        loading: false,
        query: {},
    }),

    actions: {
        //start in create
        fetchCreateData() {
            axios.get(`${this.route}/create`).then((response) => {
                this.lists = response.data.meta;
            });
        },
        //start in edit
        fetchEditData(id: Number) {
            axios.get(`${this.route}/${id}/edit`).then((response) => {
                this.entry = response.data.data ?? [];
                this.lists = response.data.meta ?? [];
            });
        },

        fetchShowData(id: Number) {
            this.loading = true;
            axios
                .get(`${this.route}/${id}`, { params: this.query })
                .then((response) => {
                    this.entry = response.data.data ?? [];
                    this.lists = response.data.meta ?? [];
                });
                this.loading = false
        },

        setRoute(route: string) {
            this.route = route;
        },

        setQuery(q: any) {
            this.query = q;
        },
    },
});
