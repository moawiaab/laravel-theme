import { Stages } from '@/types/columns';
import { defineStore } from "pinia";
import axios from "axios";
import type { Store } from "@/types";
import { Notify } from 'quasar';
import { useTables } from '../tables';
// import { useSingleSupplierOrder } from '@/stores/supplier-orders/single';

const route = "/stages";

export const useStagesIndex = defineStore("stages-store", {
    state: () => ({
        entry: <Store>{},
        lists: {
            roles: [],
        },
        loading: false,
        newRow: false,
        errors: {
            name: "",
            num: ""
        },
    }),
    getters: {
        columns: () => Stages,
        // subProducts : () => SubProducts
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
                            message: "تم إضافة المخزنة بنجاح",
                            type: 'positive',

                        })
                        if (useTables().outPage) {
                            // useSingleSupplierOrder().fetchCreateData()
                        } else {
                            useTables().getData();
                            useTables().newRow = false
                        }
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
                            message: "تم تعديل بيانات المخزنة بنجاح",
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
    }
});
