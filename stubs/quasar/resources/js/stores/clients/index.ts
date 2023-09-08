import { Amount, Clients } from '@/types/columns';
import { defineStore } from "pinia";
import axios from "axios";
import type { Client } from "@/types";
import { Notify } from 'quasar';
import { useTables } from '../tables';
import { useSingleSupplierOrder } from '@/stores/supplier-orders/single';
import { useSingleOrder } from '@/stores/orders/single';

const route = "/clients";

export const useClientsIndex = defineStore("clients-store", {
    state: () => ({
        entry: <Client>{},
        lists: {
            items: [],
        },
        loading: false,
        splitterModel: 30,
        newRow: false,
        errors: {
            name: "",
            email: "",
            password: "",
            role_id: "",
            phone: "",
        },
    }),
    getters: {
        columns: () => Clients,
        amountColumns: () => Amount
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
                        if (useTables().outPage) {
                            useSingleOrder().fetchCreateData()
                            useSingleSupplierOrder().fetchCreateData()
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
    }
});
