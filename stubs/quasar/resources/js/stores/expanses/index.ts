import { Expanses } from '@/types/columns';
import { defineStore } from "pinia";
import axios from "axios";
import type { Budget, Expanse } from "@/types";
import { Notify } from 'quasar';
import { useTables } from '../tables';

const route = "/expanses";

export const useExpansesIndex = defineStore("expanse-store", {
    state: () => ({
        entry: <Expanse>{},
        data : {},
        lists: {
            budgets: <Budget[]>{},
            roof : false
        },
        loading: false,
        rowId: 0,
        confirm: false,
        alert: false,
        amount : 100,
        expense : 0,
        errors: {
            name: "",
            email: "",
            password: "",
            role_id: "",
            phone: "",
        },
    }),
    getters: {
        columns: () => Expanses,
    },
    actions: {
        fetchCreateData() {
            axios.get(`${route}/create`).then((response) => {
                this.lists = response.data.meta;
            });
        },

        //start in edit
        fetchEditData(id: Number) {
            axios.get(`${route}/${id}/edit`).then((response) => {
                this.entry = response.data.data ?? [];
                this.lists = response.data.meta ?? [];
                // useTables().row = {}
            });
        },

        fetchShowData(id: number) {
            this.loading = true;
            axios
                .get(`${route}/${id}`)
                .then((response) => {
                    this.entry = response.data.data ?? [];
                    this.lists = response.data.meta ?? [];
                });
            this.loading = false
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

        // send data to server in updated
        updateData(id: number) {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .put(`${route}/${id}`, this.entry)
                    .then((response) => {
                        Notify.create({
                            message: "تم تعديل بيانات المستخدم بنجاح",
                            type: 'positive',

                        })
                        useTables().getData();
                        useTables().editRow = false
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

        deleteItem() {
            axios
                .delete(`${route}/${this.rowId}`, { ...this.data })
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

    }
});
