import BtnSave from "../components/Buttons/BtnSave.vue";
import Loader from "../components/Loader.vue";
import SearchFilter from "../components/SearchFilter.vue";
import DeleteItem from "../components/dialog/DeleteItem.vue";
//icons
import DeleteIcon from "../components/icons/DeleteIcon.vue";
import EditIcon from "../components/icons/EditIcon.vue";
import ShowIcon from "../components/icons/ShowIcon.vue";
import ToggleIcon from "../components/icons/ToggleIcon.vue";
import ExportMenu from "../components/dialog/ExportMenu.vue";
import ImportMenu from "../components/dialog/ImportMenu.vue";
import MainPage from "../components/pages/MainPage.vue";

import type { App } from "vue";
import Vue3EasyDataTable from "vue3-easy-data-table";
export function defaultComponent(app: App) {
    app.component("data-table", Vue3EasyDataTable);
    app.component("btn-save", BtnSave);
    app.component("Loader", Loader);
    app.component("search-filter", SearchFilter);
    app.component("delete-item", DeleteItem);

    app.component("edit-icon", EditIcon);
    app.component("toggle-icon", ToggleIcon);
    app.component("delete-icon", DeleteIcon);
    app.component("show-icon", ShowIcon);

    app.component("main-page", MainPage);
    app.component("export-menu", ExportMenu);
    app.component("import-menu", ImportMenu);
}
