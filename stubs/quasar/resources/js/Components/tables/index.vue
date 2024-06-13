<template>
    <q-page>
        <q-table
            class="my-sticky-column-table"
            flat
            :style="`height : ${$q.screen.height - 120}px`"
            :title="title"
            ref="tableRef"
            :rows="table.data"
            :columns="columns"
            v-model:pagination="table.pagination"
            :loading="table.loading"
            :filter="filter"
            binary-state-sort
            @request="onRequest"
            :selected-rows-label="table.getSelected()"
            v-model:selected="table.selected"
            :visible-columns="table.visibleColumns"
        >
            <template #loading>
                <loader v-if="table.loading" />
            </template>
            <template v-slot:top-right>
                <slot name="filter" />
                <q-input
                    dense
                    outlined
                    class="q-mr-xs"
                    debounce="300"
                    v-model="filter"
                    :placeholder="$t('g.search')"
                >
                    <template #prepend>
                        <q-icon name="search" />
                    </template>
                </q-input>

                <q-select
                    outlined
                    class="q-mr-xs"
                    v-model="table.visibleColumns"
                    multiple
                    dense
                    options-dense
                    :display-value="$q.lang.table.columns"
                    emit-value
                    map-options
                    :options="columns"
                    option-value="name"
                    :option-label="(opt) => $t(opt.label)"
                    options-cover
                    style="min-width: 100px"
                />

                <q-select
                    outlined
                    class="q-mr-xs"
                    v-model="filters"
                    dense
                    options-dense
                    emit-value
                    map-options
                    :options="table.trashedData"
                    option-value="id"
                    :option-label="(opt) => $t(opt.name)"
                    options-cover
                    style="min-width: 100px"
                />

                <q-btn
                    glossy
                    color="primary"
                    icon="archive"
                    dense
                    flat
                    rounded
                    no-caps
                    @click="exportTable"
                />
            </template>

            <!-- start expand -->

            <template #header="props" v-if="expand">
                <q-tr :props="props">
                    <q-th auto-width />
                    <q-th
                        v-for="col in props.cols"
                        :key="col.name"
                        :props="props"
                    >
                        {{ $t(col.label) }}
                    </q-th>
                </q-tr>
            </template>
            <template #header="props" v-else>
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

            <template #body="props" v-if="expand">
                <q-tr :props="props">
                    <q-td auto-width>
                        <q-btn
                            glossy
                            size="sm"
                            color="accent"
                            round
                            dense
                            @click="props.expand = !props.expand"
                            :icon="props.expand ? 'remove' : 'add'"
                        />
                    </q-td>

                    <template v-for="col in props.cols">
                        <q-td
                            v-if="col.name != 'options'"
                            :key="col.name"
                            :props="props"
                        >
                            {{ col.value }}
                        </q-td>
                    </template>

                    <q-td
                        v-if="props.row.deleted_at"
                        class="deletedItem text-right"
                    >
                        <q-btn
                            glossy
                            icon="undo"
                            dense
                            flat
                            rounded
                            color="green"
                            @click="table.restoreItem(props.row.id)"
                            v-if="
                                deletable && auth.can.includes(`${role}_delete`)
                            "
                        />
                        <q-btn
                            glossy
                            icon="delete"
                            dense
                            flat
                            rounded
                            color="red"
                            @click="deleteItem(props.row)"
                            v-if="
                                deletable && auth.can.includes(`${role}_delete`)
                            "
                        />
                    </q-td>
                    <q-td :items="props.row" class="text-right" v-else>
                        <!-- {{ props.row.name }} -->
                        <slot name="options" :props="props.row" />
                        <q-btn
                            glossy
                            :icon="`${
                                props.row.toggle
                                    ? 'mdi-toggle-switch-outline'
                                    : 'mdi-toggle-switch-off-outline'
                            }`"
                            dense
                            flat
                            rounded
                            :color="`${
                                props.row.toggle ? 'accent' : 'negative'
                            }`"
                            @click="table.toggleItem(props.row.id)"
                            v-if="toggle && auth.can.includes(`${role}_edit`)"
                        />
                        <q-btn
                            glossy
                            icon="visibility"
                            dense
                            flat
                            rounded
                            color="green"
                            @click="table.showItem(props.row)"
                            v-if="
                                viewable && auth.can.includes(`${role}_access`)
                            "
                        />
                        <q-btn
                            glossy
                            icon="edit"
                            dense
                            flat
                            rounded
                            color="info"
                            @click="table.editItem(props.row)"
                            v-if="editable && auth.can.includes(`${role}_edit`)"
                        />
                        <q-btn
                            glossy
                            icon="delete"
                            dense
                            flat
                            rounded
                            color="red"
                            @click="deleteItem(props.row)"
                            v-if="
                                deletable && auth.can.includes(`${role}_delete`)
                            "
                        />
                    </q-td>
                </q-tr>
                <q-tr v-show="props.expand" :props="props">
                    <q-td colspan="100%">
                        <div class="">
                            <slot name="table-body" :props="props" />
                        </div>
                    </q-td>
                </q-tr>
            </template>

            <!-- end expand -->

            <template #body-cell-options="props">
                <q-td
                    v-if="props.row.deleted_at"
                    class="deletedItem text-right"
                >
                    <q-btn
                        glossy
                        icon="visibility"
                        dense
                        flat
                        rounded
                        color="green"
                        @click="table.showItem(props.row)"
                        v-if="
                            viewable &&
                            auth.can.includes(`${role}_access`) &&
                            props.row.show
                        "
                    />
                    <q-btn
                        glossy
                        icon="undo"
                        dense
                        flat
                        rounded
                        color="green"
                        @click="table.restoreItem(props.row.id)"
                        v-if="deletable && auth.can.includes(`${role}_delete`)"
                    />
                    <q-btn
                        glossy
                        icon="delete"
                        dense
                        flat
                        rounded
                        color="red"
                        @click="deleteItem(props.row)"
                        v-if="deletable && auth.can.includes(`${role}_delete`)"
                    />
                </q-td>
                <q-td :items="props.row" class="text-right" v-else>
                    <!-- {{ props.row.name }} -->
                    <slot name="options" :props="props.row" />

                    <q-btn
                        glossy
                        :icon="`${
                            props.row.toggle
                                ? 'mdi-toggle-switch-outline'
                                : 'mdi-toggle-switch-off-outline'
                        }`"
                        dense
                        flat
                        rounded
                        :color="`${props.row.toggle ? 'accent' : 'negative'}`"
                        @click="table.toggleItem(props.row.id)"
                        v-if="toggle && auth.can.includes(`${role}_edit`)"
                    />
                    <q-btn
                        glossy
                        icon="visibility"
                        dense
                        flat
                        rounded
                        color="green"
                        @click="table.showItem(props.row)"
                        v-if="viewable && auth.can.includes(`${role}_access`)"
                    />
                    <q-btn
                        glossy
                        icon="edit"
                        dense
                        flat
                        rounded
                        color="info"
                        @click="table.editItem(props.row)"
                        v-if="editable && auth.can.includes(`${role}_edit`)"
                    />

                    <q-btn
                        glossy
                        icon="delete"
                        dense
                        flat
                        rounded
                        color="red"
                        @click="deleteItem(props.row)"
                        v-if="deletable && auth.can.includes(`${role}_delete`)"
                    />
                </q-td>
            </template>

            <template v-for="(_, slot) of $slots" #[slot]="props">
                <slot :name="slot" :items="props" />
            </template>
        </q-table>

        <q-dialog v-model="table.confirm" persistent>
            <q-card>
                <q-card-section class="row items-center">
                    <q-avatar
                        icon="folder_delete"
                        color="primary"
                        text-color="white"
                    />
                    <q-separator />
                    <span v-if="table.row.deleted_at" class="q-ml-sm">
                        {{ $t("d.delete2") }}
                    </span>
                    <span v-else class="q-ml-sm"> {{ $t("d.delete1") }}</span>
                    <q-separator />
                    <q-chip square>
                        {{ $t("g.id") }} : {{ table.row.id || 0 }}</q-chip
                    >
                    <q-chip square>
                        {{ $t("g.name") }} :
                        {{ table.row.name || table.row.title }}</q-chip
                    >
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn
                        glossy
                        flat
                        :label="$t('d.c')"
                        color="red"
                        v-close-popup
                    />
                    <q-btn
                        glossy
                        flat
                        :label="$t('d.d')"
                        color="primary"
                        @click="table.delete(table.row.id)"
                    />
                </q-card-actions>
            </q-card>
        </q-dialog>

        <q-page-sticky position="bottom-right" :offset="[20, 20]">
            <f-abs :data="fabBtn" />
        </q-page-sticky>
    </q-page>
</template>

<script setup>
import { useTables } from "../../stores/tables/index";
import { watch, computed, onMounted, ref } from "vue";
import exportFile from "quasar/src/utils/export-file/export-file.js";
import { useAuth } from "@/stores/auth/index";
import { useI18n } from "vue-i18n";
const { t } = useI18n();

const table = useTables();
const auth = useAuth();
table.$reset();

const props = defineProps({
    columns: { type: Array },
    title: { type: String, default: "" },
    role: { type: String, default: "" },
    router: { type: String },
    expand: { type: Boolean, default: false },
    deletable: { type: Boolean, default: true },
    editable: { type: Boolean, default: true },
    viewable: { type: Boolean, default: true },
    newRow: { type: Boolean, default: false },
    toggle: { type: Boolean, default: false },
    creatable: { type: Boolean, default: false },
});

const tableRef = ref();
const filter = ref("");
const filters = ref("");

watch(filters, (e) => {
    table.filters.trashed = e;
    table.getData();
});

function onRequest(props, col) {
    const filter = props.filter;
    table.setFilter(filter);
    table.pagination = props.pagination;
    table.pagination.sortType = table.pagination.descending ? "asc" : "desc";
    table.getData();
}

onMounted(() => {
    table.setRouter(props.router);
    // get initial data from server (1st page)
    table.visibleColumns = props.columns.map((e) => e.name);
    tableRef.value.requestServerInteraction();
});

const deleteItem = (item) => {
    table.confirm = true;
    table.row = item;
};

function wrapCsvValue(val, formatFn, row) {
    let formatted = formatFn !== void 0 ? formatFn(val, row) : val;
    formatted =
        formatted === void 0 || formatted === null ? "" : String(formatted);
    formatted = formatted.split('"').join('""');
    return `"${formatted}"`;
}

const exportTable = () => {
    // naive encoding to csv format
    const content = [props.columns.map((col) => wrapCsvValue(t(col.label)))]
        .concat(
            table.data.map((row) =>
                props.columns
                    .map((col) =>
                        wrapCsvValue(
                            typeof col.field === "function"
                                ? col.field(row)
                                : row[
                                      col.field === void 0
                                          ? col.name
                                          : col.field
                                  ],
                            col.format,
                            row
                        )
                    )
                    .join(",")
            )
        )
        .join("\r\n");

    const status = exportFile("table-export.csv", content, "text/csv");

    if (status !== true) {
        $q.notify({
            message: "Browser denied file download...",
            color: "negative",
            icon: "warning",
        });
    }
};

const fabBtn = [
    {
        color: "orange",
        icon: "add",
        label: "f.add",
        to: props.creatable ? props.router + `/create` : null,
        onClick: () => (props.creatable ? null : (table.newRow = true)),
        disable:
            table.newRow ||
            props.newRow ||
            !auth.can.includes(`${props.role}_access`),
    },
    {
        color: "green",
        icon: "sync",
        label: "f.refresh",
        onClick: () => {
            table.setRouter(props.router);
            table.getData();
        },
        disable: table.loading,
    },
    {
        color: "secondary",
        icon: "replay",
        label: "f.reset",
        onClick: () => {
            table.$reset();
            table.setRouter(props.router);
            table.visibleColumns = props.columns.map((e) => e.name);
            tableRef.value.requestServerInteraction();
            table.getData();
        },
        disable: table.loading,
    },
    {
        color: "accent",
        icon: "file_download",
        label: "f.exile",
        onClick: () => exportTable(),
    },
    { color: "primary", icon: "home", label: "f.d", to: "/" },
];
</script>

<style>
tr:has(td.deletedItem) {
    background: #ffb3bc80 !important;
}
</style>
<style lang="sass">
.my-sticky-column-table
  max-width: 100%
  thead tr:last-child th:last-child,
  thead tr:first-child th:first-child
    /* bg color is important for th; just specify one */
    background-color: #ffffff
  td:last-child,
  td:first-child
    background-color: #ffffff

  th:first-child,
  td:first-child
    position: sticky
    left: 0
    z-index: 1
  th:last-child,
  td:last-child
    position: sticky
    right: 0
    z-index: 0
tr:has(td.deletedItem)
  td
    background: #ffb3bc80 !important
</style>
