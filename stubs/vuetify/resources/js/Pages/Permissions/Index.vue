<template>
  <div class="">
      <Loader v-if="permission.loading" />
    <header-title title="الأذونات">
        <create-permission />
    </header-title>
    <div>
        <v-row align="center" no-gutters>
            <v-col>
                <search-filter :query="filters" />
            </v-col>
            <v-col class="text-left">
                <v-chip size="small" color="blue" label class="ma-2" prepend-icon="mdi-filter-cog-outline" @click="openItem">
                    بحث متقدم
                </v-chip>
                <v-chip size="small" color="green" label class="ma-2" prepend-icon="mdi-refresh"
                    @click.prevent="permission.fetchIndexData()">
                    تحديث البيانات
                    <template v-slot:append> </template>
                </v-chip>
                <v-chip size="small" color="red" label class="ma-2" prepend-icon="mdi-database-refresh-outline"
                    @click="headerItem.removeAllItem">
                    إعادة الضبط
                </v-chip>
                <!-- mdiDatabaseRefreshOutline -->
                <v-menu :close-on-content-click="false">
                    <template v-slot:activator="{ props }">
                        <v-chip size="small" color="gary" class="ma-2" prepend-icon="mdi-dots-vertical" v-bind="props" label>
                            إعدادات
                        </v-chip>
                    </template>
                    <v-list>
                        <v-list-item-title class="mx-4 text-blue">الأعمدة المعروضة</v-list-item-title>
                        <v-list-item v-for="(i, index) in headerItem.headerTable" :key="index" prepend-icon="mdi-check">
                            <v-list-item-title @click="headerItem.addItem(i)">
                                {{ i.text }}</v-list-item-title>
                        </v-list-item>
                        <v-divider />
                        <v-list-item-title class="mx-4 text-red">الأعمدة الغير معروضة</v-list-item-title>
                        <v-list-item v-for="{ text }, index in headerItem.menuItem" :key="index" prepend-icon="mdi-close">
                            <v-list-item-title @click="headerItem.removeItem(index)">
                                {{ text }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-col>
        </v-row>
    </div>
    <v-expansion-panels v-model="filtersItem">
        <v-expansion-panel value="filtersItem">
            <v-expansion-panel-text>
                <v-row no-gutters>
                    <v-col>
                        <v-radio-group inline v-model="filters.trashed">
                            <v-radio label="عرض البيانات الغير محذوفة" value="" color="info"></v-radio>
                            <v-radio label="عرض البيانات المحذوف فقط" value="only" color="info"></v-radio>
                            <v-radio label="عرض جميع البيانات معاً" value="with" color="info"></v-radio>
                        </v-radio-group>
                    </v-col>
                </v-row>
            </v-expansion-panel-text>
        </v-expansion-panel>
    </v-expansion-panels>
    <data-table :server-items-length="permission.total" buttons-pagination v-model:server-options="query"
        :headers="headerItem.headerTable" :items="permission.permissions" body-text-direction="right" :table-class-name="
            theme.theme == 'light' ? 'customize-table' : 'customize-table-small'
        " theme-color="#551a8b" :table-height="500" :loading="permission.loading" alternating border-cell
        v-model:items-selected="itemsSelected" :body-row-class-name="bodyRowClassNameFunction">
        <template #loading />
        <template #header-operation>
            <div class="delete-all-items">
                <import-menu url="permissions" />
                <export-menu url="permissions" :data="permission.permissions" />
                <v-icon icon="mdi-delete-sweep-outline" color="red" @click="permission.showDeletedMethod('delete')"
                    v-if="can('permission_delete', 'all')" />
            </div>
        </template>
        <template #item-operation="item">
            <div class="operation-wrapper text-left">
                <v-toolbar-title></v-toolbar-title>
                <!-- <v-icon icon="mdi-pencil-outline" @click="permission.editItem(item)" color="green" class="mx-1" /> -->
                <edit-icon @click="permission.editItem(item)" role="permission" v-if="!item.deleted_at" />
                <delete-icon @click="permission.showDeletedMethod(item.id)" role="permission" v-if="!item.deleted_at" />
                <delete-icon @click="permission.showDeletedMethod(item.id, true)" role="permission"
                    v-if="item.deleted_at" />
                <delete-icon @click="permission.restoreItem(item.id)" role="permission" v-if="item.deleted_at"
                    :resat="true" />
                <!-- <v-icon icon="mdi-trash-can" @click="permission.showDeletedMethod(item.id)" color="error"
                    title="حذف الإذن" class="mx-1" /> -->
            </div>
        </template>
    </data-table>

    <delete-item title="هل تريد الحذف" v-model="permission.showDeleted">
        <template #content>
            <span v-if="permission.itemId == 'delete'">
                هل تريد حذف جميع البيانات المختارة
                <v-chip v-for="item, index in itemsSelected" :text="item.details" class="ma-1" :key="index" />
            </span>
            <span v-else>هل تريد الحذف بالفعل ستفقد البيانات </span>
        </template>
        <template #footer>
            <v-btn color="blue-darken-1" prepend-icon="mdi-trash-can" variant="tonal"
                @click="permission.deleteAllItem(itemsSelected)" v-if="permission.itemId == 'delete'">
                حذف الجميع
            </v-btn>
            <v-btn color="blue-darken-1" prepend-icon="mdi-trash-can" variant="tonal" @click="permission.deleteTrash()"
                v-else-if="permission.trashed == true">
                حذف من السلة
            </v-btn>
            <v-btn color="blue-darken-1" prepend-icon="mdi-trash-can" variant="tonal" @click="permission.deleteItem()"
                v-else>
                تأكيد الحذف
            </v-btn>
            <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal"
                @click="permission.showDeleted = false">
                إلغاء الأمر
            </v-btn>
        </template>
    </delete-item>
    <edit-permission />
    <PrintList title="الأذونات" :header="headerItem.headerTable" :items="permission.permissions" />
  </div>
</template>
<script lang="ts">
import { useAbility } from '@casl/vue';
import { ref, watch } from "@vue/runtime-core";
import { usePermissions } from "../../stores/permissions";
import { useSettingsHeaderTable } from "../../stores/settings/SettingHeaderTable";
import type {
    Header,
    ServerOptions,
    Item,
    BodyRowClassNameFunction,
} from "vue3-easy-data-table";
import EditPermission from "./Edit.vue";
import CreatePermission from "./Create.vue";
import { useSetting } from "../../stores/settings/SettingIndex";
import HeaderTitle from "../../components/HeaderTitle.vue";
import SearchFilter from "../../components/SearchFilter.vue";
import PrintList from "../../components/PrintList.vue";

export default {
    name: "PermissionsIndex",
    components: {
        EditPermission,
        CreatePermission,
        HeaderTitle,
        SearchFilter,
        PrintList,
    },
    setup() {
        const { can } = useAbility();
        const theme = useSetting();
        const permission = usePermissions();
        const query = ref<ServerOptions>({
            sortBy: "id",
            sortType: "desc",
            rowsPerPage: 20,
            page: 1,
        });
        const filters = ref({ s: "", trashed: "" });
        const filtersItem = ref("");
        const openMenu = ref(false);
        const headerItem = useSettingsHeaderTable();
        const itemsSelected = ref<Item[]>([]);
        permission.fetchIndexData();
        const headers: Header[] = [
            {
                text: "اسم الصلاحية",
                value: "details",
                width: 200,
                sortable: true,
            },
            {
                text: "ربط الصلاحية",
                value: "title",
                width: 200,
                sortable: true,
            },
            { text: "تاريخ الإنشاء", value: "created_at", sortable: true },
            { text: "إعدادات", value: "operation", width: 120 },
        ];
        const bodyRowClassNameFunction: BodyRowClassNameFunction = (
            item: Item,
            index: number
        ): string => {
            if (item.deleted_at) return "delete-fail-row";
            return '';
        };
        headerItem.setHeaderItems(headers, "permissions");

        const openItem = () => {
            if (filtersItem.value) {
                filtersItem.value = "";
            } else {
                filtersItem.value = "filtersItem";
            }
        };

        watch(
            filters,
            (q) => {
                permission.setFilters(q);
                permission.fetchIndexData();
            },
            { deep: true }
        );

        watch(
            query,
            (q) => {
                permission.setQuery(q);
                permission.fetchIndexData();
            },
            { deep: true }
        );
        return {
            can,
            theme,
            headerItem,
            permission,
            query,
            filters,
            openItem,
            filtersItem,
            openMenu,
            itemsSelected,
            bodyRowClassNameFunction
        };
    },
};
</script>

<style>
/* .text-left-col {} */
</style>
