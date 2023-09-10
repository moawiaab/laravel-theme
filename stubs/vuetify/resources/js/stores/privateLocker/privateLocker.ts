import axios from "axios";
import { defineStore } from "pinia";
import { useSettingAlert } from "../settings/SettingAlert";
import { usePageIndex } from "../pages/pageIndex";

interface entryData {
    id: Number | null;
    name: String;
    email: String;
    amount: Number;
    phone: String;
    address: String;
    roof: Number;
    status: Number;
    type: Number;
    user: String;
    created_at: String;
}

const route = "private-lockers";
export const useSinglePrivate = defineStore("single-private-lockers", {
    state: () => ({
        entry: <entryData>{},
        lists: {
            items: {
                data: [],
                total: 0,
            },
        },
        loading: false,
    }),
    actions: {
        setupEntry(entry: any, lists: any) {
            this.entry = entry;
            this.lists = lists;
        },
    },
});
