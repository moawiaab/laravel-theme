import axios from "axios";
import { defineStore } from "pinia";
import { useToast } from "vue-toastification";
import { useSingleProducts } from "./single";
import Swal from "sweetalert2";

const route = "products";
const toast = useToast();
export const useProducts = defineStore("index-products", {
    state: () => ({
        products: [],
        total: 0,
        page: 1,
        query: {
            sortBy: "id",
            sortType: "desc",
            rowsPerPage: 20,
            page: 1,
        },
        filter: {
            s: "",
        },
        loading: false,
        errors: null,
    }),
    getters: {
        // items: (state) => state.products,
        // totalItem: (state) => state.total,
    },
    actions: {
        fetchIndexData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .get(route, { params: { ...this.filter, ...this.query } })
                    .then((response) => {
                        this.products = response.data.data;
                        this.total = response.data.meta.total;
                        this.page = response.data.meta.current_page;
                    })
                    .catch((error) => {})
                    .finally(() => {
                        this.loading = false;
                    });
            });
        },
        setQuery(q: any) {
            this.query = q;
        },
        setFilter(q: any) {
            this.filter = q;
        },
        editItem(item: any) {
            const products = useSingleProducts();
            products.showModalEdit = true;
            products.fetchEditData(item.id);
        },
        showItem(item: any) {
            const products = useSingleProducts();
            products.showModalShow = true;
            products.fetchShowData(item.id);
        },

        deleteItem(item: any) {
            Swal.fire({
                title: "هل تريد الحذف بالفعل",
                icon: "error",
                position: "center",
                showCancelButton: true,
                cancelButtonText: ` إلغاء الأمر`,
                confirmButtonText: `تأكيد الحذف`,
                confirmButtonColor: "#dd4b39",
                showConfirmButton: true,
                toast: false,
            }).then((result) => {
                if (result.value) {
                    axios
                        .delete(`${route}/${item.id}`)
                        .then((response) => {
                            this.fetchIndexData();
                        })
                        .catch((error) => {
                            this.errors =
                                error.response.data.errors || this.errors;
                            toast.error(error.response.data.message, {
                                timeout: 5000,
                            });
                        });
                }
            });
        },
    },
});
