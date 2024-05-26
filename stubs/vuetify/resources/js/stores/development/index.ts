import { defineStore } from "pinia";
import axios from "axios";
import { useSettingAlert } from "../settings/SettingAlert";

const route = "/development";

export const useDevelopmentIndex = defineStore("development-store", {
    state: () => ({
        entry: {
            name: null,
            type: "text",
            filed: "",
            require: false,
            num: null,
            value: null,
            belongsTo: null,
        },
        form: {
            controller: "",
            items: [],
            tab: "controller",
        },
        lists: {
            controllers: [],
            models: [],
            resources: [],
            requests: [],
            tables: [],
            table: "",
        },
        splitterModel: 30,
        loading: false,
        belongsTo: false,
        selectType: "",
        options: [
            "text",
            "integer",
            "decimal",
            "tinyText",
            "longText",
            "tinyInteger",
            "smallInteger",
            "bigInteger",
            "double",
            "boolean",
            "date",
            "phone",
            "belongsTo",
        ],

        columns: [
            { title: "name", key: "name" },
            { title: "filed", key: "filed" },
            { title: "type", key: "type" },
            { title: "value", key: "value" },
            { title: "require", key: "require" },
            { title: "options", key: "options", align: "end" },
        ],
        showModalCreateController: false,
        showModalCreateModel: false,
        showModalCreateRes: false,
        showModalCreateReq: false,
        errors: {
            controller: null,
        },
    }),

    actions: {
        fetchData() {
            axios.get(`${route}`).then((response) => {
                this.lists = response.data;
            });
        },

        // send data to server in created
        storeData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route + "/store", this.form)
                    .then((response) => {
                        useSettingAlert().setAlert(
                            "Created successfully",
                            "success",
                            true
                        );

                        this.loading = false;
                        resolve(response);
                    })
                    .catch((error) => {
                        useSettingAlert().setAlert(
                            "Logout And Login To Change ",
                            "warning",
                            true
                        );

                        this.loading = false;
                        reject(error);
                    });
            });
        },

        submittedData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route + "/storeModel", this.form)
                    .then((response) => {
                        useSettingAlert().setAlert(
                            "Created successfully",
                            "success",
                            true
                        );
                        this.loading = false;
                        resolve(response);
                    })
                    .catch((error) => {
                        useSettingAlert().setAlert(
                            "Logout And Login To Change ",
                            "warning",
                            true
                        );
                        this.loading = false;
                        reject(error);
                    });
            });
        },
        setType(type: string) {
            console.log(type);
            this.belongsTo = false;
            if (
                type == "integer" ||
                type == "bigInteger" ||
                type == "double" ||
                type == "decimal" ||
                type == "tinyInteger" ||
                type == "smallInteger"
            ) {
                this.selectType = "number";
            } else if (
                type == "text" ||
                type == "tinyText" ||
                type == "longText"
            ) {
                this.selectType = "text";
            } else if (type == "phone") {
                this.selectType = "phone";
            } else if (type == "date") {
                this.selectType = "date";
            } else if (type == "belongsTo") {
                this.selectType = "belongsTo";
                this.belongsTo = true;
            }
        },

        ucFirst(str: string) {
            if (!str) return str;
            return (
                str[0].toUpperCase() +
                str.slice(1).split(" ").join("").trim().toLowerCase()
            );
        },

        addItem() {
            if (this.entry.name != null && this.entry.name.length > 1) {
                this.form.items.push({
                    ...this.entry,
                    filed: this.entry.name,
                });
                this.entry = {
                    name: null,
                    type: "text",
                    filed: "",
                    require: false,
                    value: null,
                    belongsTo: null,
                };
            } else {
                useSettingAlert().setAlert(
                    "Logout And Login To Change ",
                    "warning",
                    true
                );
            }
        },

        deleteItem(item: any) {
            this.form.items = this.form.items.filter(i => i !== item);
        },
    },
});
