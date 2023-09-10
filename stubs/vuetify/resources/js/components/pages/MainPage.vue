<template>
	<div class="">
		<Loader v-if="pages.loading" />
		<header-title :title="title" :icon="createdItem" v-if="createNewItem">
				<slot name="create" />
		</header-title>
		<div>
			<v-row align="center" no-gutters>
				<v-col>
					<search-filter :query="filters" />
				</v-col>
				<v-col
					:class="$vuetify.locale.current == 'ar' ? 'text-left' : 'text-right'"
				>
					<v-chip
						color="blue"
						size="small"
						label
						class="ma-2"
						prepend-icon="mdi-filter-cog-outline"
						@click="openItem"
					>
						{{ $t("g.advanced_search") }}
					</v-chip>
					<v-chip
						size="small"
						color="green"
						label
						class="ma-2"
						prepend-icon="mdi-refresh"
						@click.prevent="pages.fetchIndexData()"
					>
						{{ $t("f.refresh") }}
						<template v-slot:append> </template>
					</v-chip>
					<v-chip
						size="small"
						color="red"
						label
						class="ma-2"
						prepend-icon="mdi-database-refresh-outline"
						@click="headerItem.removeAllItem"
					>
						{{ $t("g.reset_data") }}
					</v-chip>
					<!-- mdiDatabaseRefreshOutline -->
					<v-menu :close-on-content-click="false">
						<template v-slot:activator="{ props }">
							<v-chip
								size="small"
								color="gary"
								class="ma-2"
								prepend-icon="mdi-dots-vertical"
								v-bind="props"
								label
							>
								{{ $t("g.m.setting") }}
							</v-chip>
						</template>
						<v-list>
							<v-list-item-title class="mx-4 text-blue">{{
								$t("col.show")
							}}</v-list-item-title>
							<v-list-item
								v-for="(i, index) in headerItem.headerTable"
								:key="index"
								prepend-icon="mdi-check"
							>
								<v-list-item-title @click="headerItem.addItem(i)">
									{{ $t(i.text) }}</v-list-item-title
								>
							</v-list-item>
							<v-divider />
							<v-list-item-title class="mx-4 text-red">{{
								$t("col.not_show")
							}}</v-list-item-title>
							<v-list-item
								v-for="({ text }, index) in headerItem.menuItem"
								:key="index"
								prepend-icon="mdi-close"
							>
								<v-list-item-title @click="headerItem.removeItem(index)">
									{{ $t(text) }}</v-list-item-title
								>
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
							<v-radio-group v-model="filters.trashed">
								<v-radio :label="$t('table.d')" value="" color="info"></v-radio>
								<v-radio
									:label="$t('table.only')"
									value="only"
									color="info"
								></v-radio>
								<v-radio
									:label="$t('table.with')"
									value="with"
									color="info"
								></v-radio>
							</v-radio-group>
						</v-col>
						<slot name="filter" />
					</v-row>
				</v-expansion-panel-text>
			</v-expansion-panel>
		</v-expansion-panels>

		<data-table
			:server-items-length="pages.total"
			buttons-pagination
			v-model:server-options="query"
			:headers="headerItem.headerTable"
			:items="pages.data"
			:body-text-direction="$vuetify.locale.current == 'ar' ? 'right' : 'left'"
			:table-class-name="
				theme.theme == 'light' ? 'customize-table' : 'customize-table-small'
			"
			theme-color="#551a8b"
			:table-height="600"
			:loading="pages.loading"
			alternating
			border-cell
			v-model:items-selected="itemsSelected"
			:body-row-class-name="bodyRowClassNameFunction"
		>
			<template #loading />
			<template #expand="item" v-if="expand">
				<slot name="expand" :item="item" />
			</template>

			<template #header="header">
				{{ $t(header.text) }}
			</template>

			<template #header-operation>
				<v-col class="text-left">
					<import-menu :url="pages.route" v-if="addSelected" />
					<export-menu :url="pages.route" :data="pages.data" />
					<v-icon
						icon="mdi-delete-sweep-outline"
						color="red"
						@click="pages.showDeletedMethod('delete')"
						v-if="can(`${role}_delete`, 'all') && deleteAll"
					/>
				</v-col>
			</template>

			<template #item-operation="item">
				<div class="operation-wrapper" :class="$vuetify.locale.current == 'en' ? 'text-right' : 'text-left'">
					<v-toolbar-title></v-toolbar-title>
					<slot name="table-operation" :item="item" />
					<show-icon
						:role="role"
						@click="pages.showItem(item)"
						v-if="viewable"
					/>
					<edit-icon
						@click="pages.editItem(item.id)"
						:role="role"
						v-if="!item.deleted_at && editable"
					/>
					<delete-icon
						@click="pages.showDeletedMethod(item.id)"
						:role="role"
						v-if="deletable"
					/>
					<delete-icon
						@click="pages.restoreItem(item.id)"
						:role="role"
						v-if="item.deleted_at && deletable"
						:resat="true"
					/>
				</div>
			</template>

			<template v-for="(_, slot) of $slots" #[slot]="item">
				<slot :name="slot" :item="item" />
			</template>
		</data-table>

		<delete-item :title="$t('d.delete')" v-model="pages.showDeleted">
			<template #content>
				<span v-if="pages.itemId == 'delete'">
					{{ $t("d.delete_all") }}
					<br />
					<template v-for="(item, index) in itemsSelected">
						<v-chip
							:text="item.title ?? item.name"
							class="ma-1"
							v-if="item.deletable"
							:key="index"
						/>
					</template>
				</span>
				<span v-else>{{ $t("d.delete1") }}</span>
			</template>
			<template #footer>
				<v-btn
					color="blue-darken-1"
					prepend-icon="mdi-trash-can"
					variant="tonal"
					@click="pages.deleteAllItem(itemsSelected)"
					v-if="pages.itemId == 'delete'"
				>
					{{ $t("d.ok") }}
				</v-btn>
				<v-btn
					color="blue-darken-1"
					prepend-icon="mdi-trash-can"
					variant="tonal"
					@click="pages.deleteItem()"
					v-else
				>
					{{ $t("d.ok") }}
				</v-btn>
				<v-btn
					color="red-darken-1"
					prepend-icon="mdi-close"
					variant="tonal"
					@click="pages.showDeleted = false"
				>
					{{ $t("d.c") }}
				</v-btn>
			</template>
		</delete-item>
		<!-- <edit-page>
        <slot name="edit" />
    </edit-page> -->
		<slot />
		<show-page />
		<PrintList
			:title="title"
			:header="headerItem.headerTable"
			:items="pages.data"
		/>
	</div>
</template>
<script lang="ts">
import { ref, watch } from "@vue/runtime-core";
import { useAbility } from "@casl/vue";
import { usePageIndex } from "../../stores/pages/pageIndex";
import { useSettingsHeaderTable } from "../../stores/settings/SettingHeaderTable";
import type {
	Header,
	ServerOptions,
	Item,
	BodyRowClassNameFunction,
} from "vue3-easy-data-table";
import EditPage from "./Edit.vue";
import CreatePage from "./Create.vue";
import ShowPage from "./Show.vue";
import { useSetting } from "../../stores/settings/SettingIndex";
import HeaderTitle from "../../components/HeaderTitle.vue";
import PrintList from "../../components/PrintList.vue";

export default {
	name: "MainPage",
	components: {
		EditPage,
		CreatePage,
		HeaderTitle,
		PrintList,
		ShowPage,
	},

	props: {
		headers: Headers,
		expand: { type: Boolean, default: false },
		role: { type: String },
		title: { type: String },
		viewable: { type: Boolean, default: true },
		editable: { type: Boolean, default: true },
		deletable: { type: Boolean, default: true },
		deleteAll: { type: Boolean, default: true },
		addSelected: { type: Boolean, default: true },
		createdItem: { type: Boolean, default: true },
		createNewItem: { type: Boolean, default: true },
	},
	setup(props) {
		const { can } = useAbility();
		const theme = useSetting();
		const pages = usePageIndex();
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

		pages.fetchIndexData();

		const bodyRowClassNameFunction: BodyRowClassNameFunction = (
			item: Item,
			index: number
		): string => {
			if (item.deleted_at) return "delete-fail-row";
			else if (item.newItem) return "newItem-fail-row";
			return "";
		};
		headerItem.setHeaderItems(props.headers, pages.table);

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
				pages.setFilters(q);
				pages.fetchIndexData();
			},
			{ deep: true }
		);

		watch(
			query,
			(q) => {
				pages.setQuery(q);
				pages.fetchIndexData();
			},
			{ deep: true }
		);
		return {
			can,
			theme,
			headerItem,
			pages,
			query,
			filters,
			openItem,
			filtersItem,
			openMenu,
			itemsSelected,
			bodyRowClassNameFunction,
		};
	},
};
</script>
