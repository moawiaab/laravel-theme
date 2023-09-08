import { Notify } from 'quasar';
import axios from "axios";
import { defineStore } from "pinia";
import { useTables } from "@/stores/tables";
import { type Product } from '@/types';
import { LocalOrder } from '@/types/columns';
interface entryData {
    value: number | null;
    amount: number | null;
    price: number | null;
    number: number | null;
    product: string | null;
    gain: number | null;
    stores: Array<Product> | null;
}
const route = "orders";
export const useSingleOrder = defineStore("single-orders", {
    state: () => ({
        entry: <Product>{},
        lists: {
            products: [],
            suppliers: [],
            clients: [],
            stores: [],
        },
        products: <Product[]>[],
        orderType: 0,
        localData: null,
        loading: false,
        errors: <entryData>{},
        data: {
            btnTrue: false,
            localOptions: [],
            data: <entryData>{},
            localError: "",
            added: null,
        },
        total: 0,
        selectData: null,
        maxAmount: 100,
        storeId: 0,
    }),
    getters: {
        hasErrors: (state) => state.errors,
        columns: () => LocalOrder
    },
    actions: {
        //  get products
        fetchCreateData() {
            axios.get(`${route}/create`).then((response) => {
                this.lists = response.data.meta;
            });
        },
        // send data to server in created
        storeData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .post(route, {
                        ...this.entry,
                        products: this.products,
                        orderType: this.orderType,
                    })
                    .then((response) => {
                        Notify.create({
                            message: "تم إضافة فاتورة المشتريات بنجاح",
                            type: 'positive',

                        })
                        // useTables().getData();
                        resolve(response);
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors || this.errors;
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


        setAmount() {
            this.total = 0;
            this.products.forEach(
                (e: any) =>
                    (this.total += parseInt(e.price) * parseInt(e.number))
            );
        },
        setPrice() {
            if (!this.data.data.gain) this.data.data.gain = 30;
            this.data.data.price =
                (this.data.data.amount! * this.data.data.gain) / 100 +
                parseFloat(this.data.data.amount!.toString());
        },

        selectItem(item: any) {
            if(item.stores[0] === undefined){
                Notify.create({
                    message: " هذا المنتج لا يوجد في المخازن",
                    type: 'warning',

                })
            }
            this.data.localOptions = item.options;
            this.data.data = item;
            this.entry.store_id = item.stores[0].id
            this.storeId = item.stores[0].id;
            this.entry.store = item.stores[0].store_id
            this.maxAmount = item.stores[0].number
        },
        createProduct() {
            return new Promise(async (resolve) => {
                let itemBack = null
                if (this.data.data.value) {
                    this.data.localError = "";
                    const productItem = <Product>{
                        barcode: null,
                        gain: this.entry.gain,
                        id: this.data.data.value,
                        amount: this.data.data.amount,
                        price: this.data.data.price,
                        number: this.data.data.number == null
                            ? 1
                            : this.data.data.number,
                        name: this.data.data.product,
                        store_id: this.entry.store_id,
                        store: this.entry.store,
                        status: null
                    };
                    itemBack = productItem.number
                    if (productItem.number !== 0) {
                        if (this.data.data.amount) this.products.push(productItem);
                        else {
                            Notify.create({
                                message: " 3 لا تترك حقلا  فارغا من فضلك",
                                type: 'warning',

                            })
                            this.selectData = null;
                        }
                        this.data.localOptions = [];
                        // this.data.localError = null;
                    } else {
                        Notify.create({
                            message: " 1 لا تترك حقلا  فارغا من فضلك",
                            type: 'warning',

                        })
                        this.selectData = null;
                    }
                } else {
                    Notify.create({
                        message: "اختر الصنف من فضلك",
                        type: 'warning',
                    })
                    this.selectData = null;
                }
                this.data.data = {
                    value: null,
                    amount: null,
                    price: null,
                    number: null,
                    product: null,
                    gain: null,
                    stores: []
                };
                // this.selectData = null;
                // setAmount();
                this.setAmount();
                resolve(itemBack);
            })
        },

        deleteProduct(item: any) {
            this.products.splice(item, 1);
            this.setAmount();
        },
        removeProduct(item: any) {
            this.products[item].number! -= 1;
            this.setAmount();
        },

        addProduct(item: number) {
            this.products[item].number =
                parseFloat(this.products[item].number!.toString()) + 1;
            this.setAmount();
        },
    },
});
