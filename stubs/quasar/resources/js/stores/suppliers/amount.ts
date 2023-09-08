import axios from "axios"
import { Notify } from 'quasar';
import { useTables } from "@/stores/tables";
import { type Supplier, } from "@/types";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useSupplierAmounts = defineStore("supplier_amounts_store", () => {
    const entry = ref<Supplier>({
        id: null,
        name: null,
        amount: 0,
        budget_id: null,
        value: undefined,
        address: null
    })

    const data = ref({
        amount: null,
        type: 1,
        status: 1,
        details: null,
    })
    const dialog = ref(false)
    const route = "/suppliers";

    const type = [
        { value: 1, label: "input.list.cash" },
        { value: 2, label: "input.list.bankak" },
        { value: 3, label: "input.list.card" },
        { value: 4, label: 'input.list.order' },
        { value: 5, label: "input.list.check" },
        { value: 6, label: "input.list.other" },
    ]


    const status = ref([
        { value: 0, label: "input.supplier.status0" },
        {
            value: 1, label: "input.supplier.status1",
        },
    ])

    const errors = ref({
        amount: "",
        type: "",
        details: "",
        name: "",
        num: "",
        bank: "",
        date: "",
    })

    const loading = ref(false)


    const setData = (data: any) => {
        dialog.value = true
        entry.value = data
    }
    const sendAmount = () => {
        loading.value = true;
        return new Promise(async (resolve, reject) => {
            await axios
                .put(`${route}/${entry.value.id}/amount`, data.value)
                .then((response) => {
                    Notify.create({
                        message: "تم إضافة التوريدة بنجاح",
                        type: 'positive',
                    })
                    useTables().getData();
                    loading.value = false;
                    dialog.value = false
                    resolve(response);
                })
                .catch((error) => {
                    Notify.create({
                        message: error.response.data.message,
                        type: 'warning',
                    })
                    loading.value = false;
                    reject(error);
                });
        });
    }
    return {
        data, entry, sendAmount, setData, dialog, loading, type,
        status, errors
    }
})
