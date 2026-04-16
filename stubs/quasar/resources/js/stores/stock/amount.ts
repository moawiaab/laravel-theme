import axios from "axios"
import { Notify } from 'quasar';
import { useTables } from "@/stores/tables";
import { type Stock } from "@/types";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useAmountStock = defineStore("amountsStock_store", () => {
    const entry = ref<Stock>({
        id: null,
        name: null,
        amount: null,
        phone : null
    })
    const dialog = ref(false)
    const route = "/stocks";
    const stockList = ref();

    const loading = ref(false)
    const data = ref({ amount: null, details: null })

    const setData = (data: any) => {
        dialog.value = true
        entry.value = data
        fetchCreateData()
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

   const fetchCreateData = () => {
        axios.get(`${route}/${entry.value.id}/all`).then((response) => {
            stockList.value = response.data.data;
        });
    }
    return { data, entry, sendAmount, setData, dialog, loading, stockList, fetchCreateData }
})
