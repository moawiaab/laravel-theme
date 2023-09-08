import { Notify } from 'quasar';
import axios from "axios";
import { useTables } from '@/stores/tables';
import { defineStore } from 'pinia';

interface ID {
    id: number | null
}
export const useImageUpload = defineStore('useImageUpload', {
    state: () => ({
        data: <ID>{},
        loading: false,
        dialog: false,
        done: false,
        errors: {},
        route: "",
        file: null,
        collection: "",
        uploadPercentage: {},
    }),
    actions: {
        uploadImage() {
            return new Promise(async (resolve, reject) => {
                this.loading = true;
                const formData = new FormData();
                // formData.append("id", file.index);
                formData.append("file", this.file!);
                formData.append("model_id", this.data.id!.toString());
                formData.append("collection_name", this.collection);
                await axios
                    .post(`${this.route}/media`, formData, {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    })
                    .then((response) => {
                        Notify.create({
                            message: "تم تحميل الصورة بنجاح",
                            type: 'positive',
                        })
                        this.dialog = false
                        useTables().getData();
                        resolve(response);
                    })
                    .catch((error) => {
                        Notify.create({
                            message: error.response.data.message,
                            type: 'warning',
                        })
                        reject(error);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },

        setData(prop: any, route: string, collection: string) {
            this.route = route;
            this.data = prop;
            this.dialog = true;
            this.collection = collection
        },

        factoryFn(file: File) {
            console.log("🚀 ~ file: image.ts:65 ~ factoryFn ~ file:", file)

            return new Promise((resolve, reject) => {
                resolve({
                    url: `${this.route}/media`,
                    method: 'POST',
                    headers: [
                        { name: 'Content-Type', value: 'application/json' },
                        { name: 'Accept', value: 'application/json' },
                        { name: 'x-Requested-With', value: 'XMLHttpRequest' }
                    ],
                    arguments: {
                        model_id: this.data.id!.toString(),
                        collection_name: this.collection
                    },

                })
            })
        }
    }
});
