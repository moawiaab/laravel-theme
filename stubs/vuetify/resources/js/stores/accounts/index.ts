import axios from "axios";
import { defineStore } from "pinia";
import { useSingleAccounts } from "./single";

const route = "accounts";
export const useAccountIndex = defineStore("index-accounts", {
    state: () => ({
        accounts: [],
        total: 0,
        page: 1,
        query: {
            sortBy: "id",
            sortType: "desc",
            rowsPerPage: 20,
            page: 1,
        },
        loading: false,
    }),
    getters: {
        // items: (state) => state.accounts,
        // totalItem: (state) => state.total,
    },
    actions: {
        fetchIndexData() {
            this.loading = true;
            return new Promise(async (resolve, reject) => {
                await axios
                    .get(route, { params: this.query })
                    .then((response) => {
                        this.accounts = response.data.data;
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
        editItem(item: any) {
            const accounts = useSingleAccounts();
            accounts.showModalEdit = true;
            accounts.fetchEditData(item.id);
        },
        showItem(item: any) {
            const accounts = useSingleAccounts();
            accounts.showModalShow = true;
            accounts.fetchShowData(item.id);
        },
        lockItem(item: any) {
            // Swal.fire({
            //     confirmButtonText: ` تغيرالحالة`,
            //     cancelButtonText: ` إلغاء الأمر`,
            //     title: "هل تريد تغيير الحالة بالفعل",
            //     text: "يتم تغير الحالة من الفتح الى الإغلاق والعكس",
            //     icon: "question",
            //     position: "center",
            //     showCancelButton: true,
            //     confirmButtonColor: "rgb(21, 99, 221)",
            //     showConfirmButton: true,
            //     toast: false,
            // }).then((result) => {
            //     if (result.value) {
            //         axios
            //             .put(`${route}/${item.id}/toggle`)
            //             .then((response) => {
            //                 this.fetchIndexData();
            //             })
            //             .catch((error) => {});
            //     }
            // });
        },
        deleteItem(item: any) {
            // Swal.fire({
            //     title: "هل تريد الحذف بالفعل",
            //     icon: "error",
            //     position: "center",
            //     showCancelButton: true,
            //     cancelButtonText: ` إلغاء الأمر`,
            //     confirmButtonText: `تأكيد الحذف`,
            //     confirmButtonColor: "#dd4b39",
            //     showConfirmButton: true,
            //     toast: false,
            // }).then((result) => {
            //     if (result.value) {
            //         axios
            //             .delete(`${route}/${item.id}`)
            //             .then((response) => {
            //                 this.fetchIndexData();
            //             })
            //             .catch((error) => {});
            //     }
            // });
        },
    },
});
