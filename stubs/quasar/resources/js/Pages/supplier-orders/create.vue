<script lang="ts" setup>
import { type Product } from "@/types/index";
import { useSingleSupplierOrder } from "@/stores/supplier-orders/single";
import { useProductsIndex } from "@/stores/products/index";
import { useStoresIndex } from "@/stores/stores/index";
import { useSuppliersIndex } from "@/stores/suppliers/index";
import { useClientsIndex } from "@/stores/clients/index";
import { Notify } from "quasar";
import { useTables } from "@/stores/tables/index";
import { useForms } from "@/Composables/rules";
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import CreateProduct from "@/Pages/products/create.vue";
import CreateStore from "@/Pages/stores/create.vue";
import CreateSupplier from "@/Pages/suppliers/create.vue";
import CreateClient from "@/Pages/clients/create.vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const table = useTables();
const product = useProductsIndex();
const store = useStoresIndex();
const supplier = useSuppliersIndex();
const client = useClientsIndex();
const { rules: rulesData } = useForms();
const rules = rulesData;
const single = useSingleSupplierOrder();
const options = ref();
const barcode = ref();

const router = useRouter();

const splitterModel = ref(30);

onMounted(() => {
    single.fetchCreateData();
});

const filterFn = (
    val: string,
    update: (arg0: { (): void; (): void }) => void
) => {
    if (val === "") {
        update(() => {
            options.value = single.lists.products;

            // here you have access to "ref" which
            // is the Vue reference of the QSelect
        });
        return;
    }

    update(() => {
        const needle = val.toLowerCase();
        options.value = single.lists.products.filter(
            (v: { name: string | any[] }) => v.name.includes(needle)
        );
    });
};

const selectedItem = (item: any) => {
    if (single.selectData) {
        single.selectItem(item);
        single.data.localError = "";
    }
};

const setData = () => {
    const data = single.lists.products.find((item: Product) => {
        if (item.barcode == barcode.value) {
            selectedItem(item);
        } else {
            return null;
        }
    });
    barcode.value = null;
};
const onSubmit = () => {
    single.createProduct();
};

const sentToServer = () => {
    if (single.products.length <= 0) {
        Notify.create({
            message: t("input.order.local_m"),
            type: "warning",
        });
    } else {
        single.storeData().then(() => {
            single.$reset();
            table.$reset();
            router.back();
        });
    }
};
</script>

<template>
    <q-page>
        <q-splitter
            v-model="splitterModel"
            style="height: 100%"
            :limits="[15, 40]"
        >
            <template #before>
                <div class="q-pa-xs">
                    <q-card-section>
                        <q-form @submit="onSubmit">
                            <q-select
                                map-options
                                emit-value
                                filled
                                clearable
                                dense
                                hide-bottom-space
                                v-model="single.selectData"
                                :options="options"
                                :label="$t('input.order.selectProduct')"
                                :rules="[
                                    (val) => val != null || $t('v.selected'),
                                ]"
                                option-label="name"
                                option-value="id"
                                @update:model-value="selectedItem"
                                use-input
                                @filter="filterFn"
                            >
                                <template #after>
                                    <q-btn
                                        icon="mdi-plus-thick"
                                        dense
                                        rounded
                                        glossy
                                        @click="product.newRow = true"
                                        color="grey-1"
                                        class="text-green"
                                    />
                                </template>
                            </q-select>
                            <div class="row q-py-sm">
                                <div class="col q-pr-xs">
                                    <q-input
                                        filled
                                        clearable
                                        dense
                                        type="number"
                                        v-model="single.data.data.number"
                                        :label="$t('input.product.num')"
                                    />
                                </div>
                                <div class="col q-pl-xs">
                                    <q-input
                                        filled
                                        clearable
                                        dense
                                        type="number"
                                        v-model="single.data.data.amount"
                                        :label="$t('input.product.amount')"
                                    />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col q-pr-xs">
                                    <q-input
                                        filled
                                        clearable
                                        dense
                                        type="number"
                                        v-model="single.data.data.gain"
                                        :label="$t('input.product.gain')"
                                    />
                                </div>
                                <div class="col q-pl-xs">
                                    <q-input
                                        filled
                                        clearable
                                        dense
                                        type="number"
                                        v-model="single.data.data.price"
                                        :label="$t('input.product.price')"
                                    />
                                </div>
                            </div>

                            <q-select
                                class="q-pt-sm"
                                map-options
                                emit-value
                                filled
                                clearable
                                dense
                                hide-bottom-space
                                v-model="single.entry.store_id"
                                :options="single.lists.stores"
                                :label="$t('input.order.store')"
                                :rules="[
                                    (val) => val != null || $t('v.selected'),
                                ]"
                                option-label="name"
                                option-value="id"
                            >
                                <template #after>
                                    <q-btn
                                        icon="mdi-plus-thick"
                                        dense
                                        rounded
                                        glossy
                                        @click="store.newRow = true"
                                        color="grey-1"
                                        class="text-green"
                                    />
                                </template>
                            </q-select>

                            <q-btn
                                glossy
                                dense
                                class="q-my-sm full-width text-blue"
                                :label="$t('input.order.add')"
                                type="submit"
                                color="ger-2"
                                :loading="single.loading"
                                icon="mdi-plus-thick"
                            />
                        </q-form>
                        <q-separator />
                        <div class="q-pa-sm">
                            <q-item-label caption class="q-my-xs">
                                {{ $t("g.type") }}
                            </q-item-label>
                            <q-item>
                                <q-radio
                                    dense
                                    v-model="single.orderType"
                                    checked-icon="task_alt"
                                    unchecked-icon="panorama_fish_eye"
                                    :val="0"
                                    :label="$t('input.supOrder.s0')"
                                    class="q-pr-md"
                                />
                                <q-separator vertical />
                                <q-radio
                                    dense
                                    v-model="single.orderType"
                                    checked-icon="task_alt"
                                    unchecked-icon="panorama_fish_eye"
                                    :val="1"
                                    :label="$t('input.supOrder.s1')"
                                    class="q-pl-md"
                                />
                            </q-item>
                            <q-form @submit.prevent="sentToServer">
                                <q-select
                                    map-options
                                    emit-value
                                    filled
                                    clearable
                                    dense
                                    v-if="single.orderType == 0"
                                    hide-bottom-space
                                    v-model="single.entry.supplier_id"
                                    :options="single.lists.suppliers"
                                    :label="$t('input.supplier.name')"
                                    :rules="[
                                        (val) =>
                                            val != null || $t('v.selected'),
                                    ]"
                                    option-label="name"
                                    option-value="id"
                                >
                                    <template #after>
                                        <q-btn
                                            icon="mdi-plus-thick"
                                            dense
                                            rounded
                                            glossy
                                            @click="supplier.newRow = true"
                                            color="grey-1"
                                            class="text-green"
                                        />
                                    </template>
                                </q-select>
                                <q-select
                                    map-options
                                    emit-value
                                    filled
                                    clearable
                                    dense
                                    v-else
                                    hide-bottom-space
                                    v-model="single.entry.client_id"
                                    :options="single.lists.clients"
                                    :label="$t('input.client.name')"
                                    :rules="[
                                        (val) =>
                                            val != null || $t('v.selected'),
                                    ]"
                                    option-label="name"
                                    option-value="id"
                                >
                                    <template #after>
                                        <q-btn
                                            icon="mdi-plus-thick"
                                            dense
                                            rounded
                                            glossy
                                            @click="client.newRow = true"
                                            color="grey-1"
                                            class="text-green"
                                        />
                                    </template>
                                </q-select>
                                <q-input
                                    filled
                                    clearable
                                    dense
                                    class="q-my-sm"
                                    :label="$t('input.order.details')"
                                    v-model="single.entry.details"
                                    type="textarea"
                                />

                                <q-btn
                                    glossy
                                    dense
                                    class="q-my-sm full-width text-green"
                                    :label="$t('input.order.send')"
                                    type="submit"
                                    color="green-1"
                                    icon="mdi-content-save-plus-outline"
                                    :loading="single.loading"
                                />
                            </q-form>
                        </div>
                    </q-card-section>
                </div>
            </template>

            <template #separator>
                <q-avatar
                    color="blue"
                    text-color="white"
                    size="20px"
                    icon="drag_indicator"
                />
            </template>

            <template #after>
                <!-- <div class="q-pa-sm"> -->
                <q-card-section>
                    <q-table :rows="single.products" :columns="single.columns">
                        <template #body-cell-operation="props">
                            <q-td class="text-right">
                                <q-btn
                                    glossy
                                    @click="single.addProduct(props.rowIndex)"
                                    icon="mdi-plus-thick"
                                    flat
                                    dense
                                    color="info"
                                    size="sm"
                                    class="q-mr-xs bg-grey-2"
                                    rounded
                                />
                                <q-btn
                                    glossy
                                    @click="
                                        single.removeProduct(props.rowIndex)
                                    "
                                    icon="mdi-minus-thick"
                                    flat
                                    dense
                                    color="red"
                                    size="sm"
                                    class="q-mr-xs bg-grey-2"
                                    rounded
                                />
                            </q-td>
                        </template>

                        <template #body-cell-options="props">
                            <q-td class="text-right">
                                <q-btn
                                    @click="
                                        single.deleteProduct(props.rowIndex)
                                    "
                                    icon="mdi-trash-can"
                                    flat
                                    dense
                                    color="red"
                                    size="md"
                                />
                            </q-td>
                        </template>

                        <template #body-cell-allAmount="props">
                            <q-td class="text-center">
                                {{ props.row.number * props.row.amount }}
                            </q-td>
                        </template>

                        <template #body-cell-store="props">
                            <q-td class="text-center">
                                {{
                                    single.lists.stores.find(
                                        (store) =>
                                            store.id === props.row.store_id
                                    ).name
                                }}
                            </q-td>
                        </template>

                        <template #top v-if="single.data.localOptions">
                            <q-chip
                                class="glossy"
                                square
                                v-for="(item, index) in single.data
                                    .localOptions"
                                :key="index"
                                :label="item"
                            />
                        </template>
                        <template #bottom-row>
                            <q-td colspan="2" class="bg-grey-3">
                                {{ $t("input.order.num") }} :
                            </q-td>
                            <q-td class="bg-grey-3">
                                {{ single.products.length }}
                            </q-td>
                            <q-td class="bg-grey-3">
                                <q-chip
                                    dense
                                    class="text-red"
                                    square
                                    v-if="single.orderType == 1"
                                    :label="$t('input.supOrder.s0')"
                                />
                                <q-chip
                                    class="text-info"
                                    dense
                                    square
                                    v-if="single.orderType == 0"
                                    :label="$t('input.supOrder.s1')"
                                />
                            </q-td>
                            <q-td class="bg-grey-3"> </q-td>
                            <q-td colspan="2" class="bg-grey-3">
                                {{ $t("g.amount") }} :
                            </q-td>
                            <q-td class="text-center bg-grey-3">
                                {{ single.total }}
                            </q-td>
                            <q-td class="bg-grey-3" />
                        </template>
                        <template #header="props">
                            <q-tr :props="props">
                                <q-th
                                    v-for="col in props.cols"
                                    :key="col.name"
                                    :props="props"
                                >
                                    {{ $t(col.label) }}
                                </q-th>
                            </q-tr>
                        </template>
                    </q-table>
                </q-card-section>
                <!-- </div> -->
            </template>
        </q-splitter>
        <create-product />
        <create-store />
        <create-supplier />
        <create-client />
    </q-page>
</template>

<style scoped></style>
