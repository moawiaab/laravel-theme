import { Checks } from '@/types/columns';
import { defineStore } from "pinia";
import axios from "axios";
import type { Check } from "@/types";
import { Notify } from 'quasar';
import { useTables } from '../tables';

const route = "/checks";

export const useChecksIndex = defineStore("checks-store", {
    state: () => ({
        entry: <Check>{},
        lists: {
            roles: [],
        },
        loading: false,
    }),
    getters: {
        columns: () => Checks,
    },
    actions: {

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

        setDone(childId : number) {
            this.loading = true;
            axios
                .put(`${route}/${childId}/done`)
                .then((response) => {
                    useTables().getData();
                    // this.fetchShowData(1)
                    // this.alert = false
                    // this.childId = null;
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
