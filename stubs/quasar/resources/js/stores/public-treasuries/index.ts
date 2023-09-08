import { PublicTreasuries } from '@/types/columns';
import { defineStore } from "pinia";
import axios from "axios";
import { Notify } from 'quasar';
import { useTables } from '../tables';

const route = "/public-treasuries";

export const usePublicTreasuriesIndex = defineStore("public-treasuries-store", {
    state: () => ({
        entry: {},
        lists: {
            pub: [],
            expanses: [],
            pubItems: []
        },
        rowId: 0,
        details: "",
        loading: false,
        confirm: false,
        alert: false,
        errors: {
            amount: "",
            user_id: "",
        },
    }),
    getters: {
        columns: () => PublicTreasuries,
    },
    actions: {
        fetchShowData(id: number) {
            this.loading = true;
            axios
                .get(`${route}/${id}`)
                .then((response) => {
                    this.lists = response.data ?? [];
                });
            this.loading = false
        },

        setData(data: number) {
            this.rowId = data;

        },

        deleteItem() {
            axios
                .delete(`${route}/${this.rowId}`, { ...this.entry })
                .then((response) => {
                    useTables().getData();
                    this.confirm = false
                    this.rowId = 0;
                })
                .catch((error) => {
                    Notify.create({
                        message: error.response.data.message,
                        type: 'warning',
                    })
                })
                .finally(() => (this.loading = false));
        },
        setDone() {
            this.loading = true;
            axios
                .put(`${route}/${this.rowId}/done`)
                .then((response) => {
                    useTables().getData();
                    this.fetchShowData(1)
                    this.alert = false
                    this.rowId = 0;
                })
                .catch((error) => {
                    Notify.create({
                        message: error.response.data.message,
                        type: 'warning',
                    })
                })
                .finally(() => (this.loading = false));
        },
        // send data to server in created
        storeData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route, this.entry)
                    .then((response) => {
                        Notify.create({
                            message: "تم إضافة المستخدم بنجاح",
                            type: 'positive',

                        })
                        useTables().getData();
                        useTables().newRow = false
                        this.loading = false;
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        Notify.create({
                            message: error.response.data.message,
                            type: 'warning',

                        })
                        this.loading = false;
                        reject(error);
                    });
            });
        },
    }
});
