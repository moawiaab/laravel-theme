import axios from "axios"
import { defineStore } from "pinia";
import { Notify } from 'quasar';
import {type Setting } from "@/types";
import { ref } from "vue";

export const useSettingsSide = defineStore("setting_side_store", () => {
    const entry = ref<Setting>()
    const route = "/settings";

    const loading = ref(false)

    const fetchGetData = async () => {
        await axios.get(route).then((response) => {
            entry.value = response.data ?? {};
        });
    };

    const setSetting = async () => {
        loading.value = true;
        await axios
            .post(`${route}/data`, entry.value)
            .then((response) => {
                Notify.create({
                    message: "تم  تحديث الإعدادات بنجاح",
                    type: 'positive',
                })
                loading.value = false;
            })
            .catch((error) => {
                Notify.create({
                    message: error.response.data.message,
                    type: 'warning',
                })
                loading.value = false;
            });
    }
    return {entry, setSetting, loading ,fetchGetData}
})
