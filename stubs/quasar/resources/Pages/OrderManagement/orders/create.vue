<script lang="ts" setup>
import { type Store, type Product } from "@/types/index";
import { useSingleOrder } from "@/stores/orders/single";
import { useClientsIndex } from "@/stores/clients/index";
import { Notify } from "quasar";
import { useTables } from "@/stores/tables/index";
import { useRouter } from "vue-router";
import { ref, onMounted } from "vue";
import { useForms } from "@/Composables/Forms";
import PageCreatesClient from "@/Pages/clients/create.vue";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const table = useTables();
const client = useClientsIndex();
const { rules: rulesData } = useForms();
const rules = rulesData;
const single = useSingleOrder();
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

const onReset = () => {
    single.entry.store_id = null;
};

let store = <Product>{};
const selectedStore = (e: any) => {
    store = {
        ...single.data.data.stores?.find((store: Store) => store.id == e)!,
    };
    single.entry.store = store.store_id;
    single.maxAmount = store.number!;
    single.storeId = store.id!;
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
    single.createProduct().then((e: number) => {
        if (single.storeId <= 0) {
            minusNumber(
                parseInt(store.id!.toString()),
                parseInt(e!.toString())
            );
        } else {
            minusNumber(single.storeId, parseInt(e!.toString()));
        }
    });
};

const minusNumber = (e: number, minus: number) => {
    single.lists.products.filter((store: Product) => {
        if (store.id == e) {
            store.number! -= minus;
        }
    });
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
                        <q-form @submit="onSubmit" @reset="onReset">
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
                            />
                            <div class="row q-py-sm">
                                <div class="col q-pr-xs">
                                    <q-input
                                        filled
                                        clearable
                                        dense
                                        type="number"
                                        v-model="single.data.data.number"
                                        :label="$t('input.product.num')"
                                        :max="single.maxAmount"
                                        min="1"
                                    />
                                </div>
                                <div class="col q-pl-xs">
                                    <q-input
                                        hide-bottom-space
                                        filled
                                        clearable
                                        dense
                                        type="number"
                                        v-model="single.data.data.price"
                                        :label="$t('input.product.price')"
                                        :min="single.data.data.amount"
                                        :rules="[
                                            (val) => !!val || $t('v.required'),
                                        ]"
                                    />
                                </div>
                            </div>
                            <q-select
                                map-options
                                emit-value
                                filled
                                clearable
                                dense
                                hide-bottom-space
                                v-model="single.entry.store_id"
                                :options="single.data.data.stores"
                                :label="$t('input.order.store')"
                                :rules="[
                                    (val) => val != null || $t('v.selected'),
                                ]"
                                option-label="store"
                                option-value="id"
                                @update:model-value="selectedStore"
                            >
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
                                    :label="$t('input.order.s0')"
                                    class="q-pr-md"
                                />
                                <q-separator vertical />
                                <q-radio
                                    dense
                                    v-model="single.orderType"
                                    checked-icon="task_alt"
                                    unchecked-icon="panorama_fish_eye"
                                    :val="1"
                                    :label="$t('input.order.s1')"
                                    class="q-pl-md"
                                />
                            </q-item>
                            <q-form @submit.prevent="sentToServer">
                                <q-input
                                    filled
                                    clearable
                                    v-if="single.orderType == 1"
                                    dense
                                    type="number"
                                    v-model="single.entry.amount"
                                    :label="$t('input.order.amount_add')"
                                    class="q-pb-sm"
                                />
                                <q-input
                                    filled
                                    clearable
                                    v-if="single.orderType == 1"
                                    dense
                                    type="date"
                                    :label="$t('g.payments.payment_date')"
                                    class="q-pb-sm"
                                    v-model="single.entry.payment"
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    hide-bottom-space
                                />
                                <q-select
                                    map-options
                                    emit-value
                                    filled
                                    clearable
                                    dense
                                    hide-bottom-space
                                    v-model="single.entry.client_id"
                                    :options="single.lists.clients"
                                    :label="t('input.client.name')"
                                    :rules="[
                                        (val) =>
                                        single.orderType == 0 || $t('v.selected'),
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
                                    :label="$t('input.order.discount')"
                                    v-model="single.entry.discount"
                                    type="number"
                                />
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
                                        (store) => store.id === props.row.store
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
                                    :label="$t('input.order.s0')"
                                />
                                <q-chip
                                    class="text-info"
                                    dense
                                    square
                                    v-if="single.orderType == 0"
                                    :label="$t('input.order.s1')"
                                />
                            </q-td>
                            <q-td class="bg-grey-3"> </q-td>
                            <q-td colspan="2" class="bg-grey-3">
                                {{ $t("g.amount") }}:</q-td
                            >
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
        <page-creates-client />
    </q-page>
</template>

<style scoped></style>
