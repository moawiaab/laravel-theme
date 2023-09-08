import { SupOrders, SupplierOrders } from '@/types/columns';
import axios from "axios";
import type { SupplierOrder } from "@/types";
import { Notify } from 'quasar';
import { useTables } from '../tables';
import { defineStore } from 'pinia';

const route = "/supplier-orders";

export const useSupplierOrdersIndex = defineStore("supplier-orders-store", {
    state: () => ({
        entry: <SupplierOrder>{},
        lists: {
            roles: [],
        },
        loading: false,
        alert: false,
        confirm : false,
        rowId: null,
        childId : null,
        errors: {
            name: "",
            num: ""
        },
    }),
    getters: {
        columns: () => SupplierOrders,
        supOrder: () => SupOrders
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
        setDone() {
            this.loading = true;
            axios
                .put(`${route}/${this.childId}/done`)
                .then((response) => {
                    useTables().getData();
                    // this.fetchShowData(1)
                    this.alert = false
                    this.childId = null;
                })
                .catch((error) => {
                    Notify.create({
                        message: error.response.data.message,
                        type: 'warning',
                    })
                })
                .finally(() => (this.loading = false));
        },

        delete() {
            axios
                .delete(`${route}/${this.rowId}`)
                .then((response) => {
                    Notify.create({
                        message: 'تم استلام جميع الاصناف بنجاح!',
                        type: 'positive',

                    })
                    useTables().getData();
                    this.rowId = null,
                    this.confirm = false;
                })
                .catch((error) => {
                    Notify.create({
                        message: error.response.data.message || "",
                        type: "warning"
                    })
                });
        },
    }
});
