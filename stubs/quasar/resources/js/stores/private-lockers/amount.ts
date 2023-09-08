import axios from "axios"
import { Notify } from 'quasar';
import { useTables } from "@/stores/tables";
import { type PrivateLocker } from "@/types";
import { defineStore } from "pinia";
import { ref } from "vue";

export const useAmounts = defineStore("amounts_store", () => {
    const entry = ref<PrivateLocker>({
        id: null,
        name: null,
        amount: null,
        user_id: null,
        account_id: null,
        created_at: null,
        value: undefined
    })
    const dialog = ref(false)
    const route = "/private-lockers";

    const loading = ref(false)
    const data = ref({ amount: null, details: null })

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
    return { data, entry, sendAmount, setData, dialog, loading }
})
