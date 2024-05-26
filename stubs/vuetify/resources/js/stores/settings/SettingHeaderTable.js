import { defineStore } from "pinia";
import axios from "axios";
import * as XLSX from "xlsx";
import { utils, writeFileXLSX } from "xlsx";
import { useSettingAlert } from "./SettingAlert";

export const useSettingsHeaderTable = defineStore("settings-header-table", {
    state: () => ({
        headers: [
            {
                text: "",
                value: "",
            },
        ],
        items: {
            accounts: [],
            users: [],
            roles: [],
            permissions: [],
            //tableNames
        },
        table: "",
        fileData: [],
        file: null,
        arrayBuffer: null,
        loading: false,
    }),
    getters: {
        menuItem: (state) => state.items[state.table],
        headerTable: (state) =>
            state.headers.filter((e) => {
                let list = state.items[state.table].map((e) => e.value);
                return !list.includes(e.value);
            }),
    },

    actions: {
        addItem(item) {
            this.items[this.table].push(item);
        },
        removeItem(index) {
            this.items[this.table].splice(index, 1);
        },

        setHeaderItems(headers, table) {
            this.table = table;
            this.headers = headers;
        },

        removeAllItem() {
            this.items[this.table] = [];
        },

        downloadFile(route, params) {
            console.log("router = " + route, " params = " + params);
            axios
                .get(`${route}-export`, {
                    params: params,
                })
                .then((response) => {
                    // const url = window.URL.createObjectURL(
                    //     new Blob([response.data])
                    // );
                    // const link = document.createElement("a");
                    // link.href = url;
                    // link.setAttribute("download", `${Date.now()}.xlsx`);
                    // document.body.appendChild(link);
                    // link.click();
                })
                .catch((error) => {});
        },

        exportFile(data, exposal = "xlsx", url = "table") {
            const ws = utils.json_to_sheet(data);
            const wb = utils.book_new();
            utils.book_append_sheet(wb, ws, "Data");
            writeFileXLSX(wb, `${url}-${Date.now()}.${exposal}`);
        },

        async generatePDF(route) {},

        addFile(event) {
            this.loading = true;
            this.file = event.target.files[0];
            let fileReader = new FileReader();
            fileReader.readAsArrayBuffer(this.file);
            fileReader.onload = (e) => {
                this.arrayBuffer = fileReader.result;
                let data = new Uint8Array(this.arrayBuffer);
                let arr = new Array();
                for (let i = 0; i != data.length; ++i)
                    arr[i] = String.fromCharCode(data[i]);
                let bstr = arr.join("");
                let workbook = XLSX.read(bstr, { type: "binary" });
                let first_sheet_name = workbook.SheetNames[0];
                let worksheet = workbook.Sheets[first_sheet_name];
                this.fileData = XLSX.utils.sheet_to_json(worksheet, {
                    raw: true,
                });
                this.loading = false;
            };
        },

        storeData(url) {
            this.loading = true;
            const sendData = this.fileData.filter(
                (e) => e.value != "id" || e.value != "options"
            );
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(`${url}/add-all`, [this.fileData])
                    .then((response) => {
                        useSettingAlert().setAlert(
                            "تم إضافة جميع البيانات بنجاح",
                            "success",
                            true
                        );
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
                        useSettingAlert().setAlert(
                            error.response.data.message,
                            "success",
                            true
                        );
                        reject(error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
    },
    // persist: true,
});
