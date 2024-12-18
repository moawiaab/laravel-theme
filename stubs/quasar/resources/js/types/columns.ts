import {
    detailsText,
    formatNumber,
} from "../formats";

export const Users = [
    {
        name: "name",
        required: true,
        label: "g.user_name",
        align: "left",
        field: "name",
        sortable: true,
    },
    {
        name: "email",
        align: "left",
        label: "g.email",
        field: "email",
        sortable: true,
    },
    {
        name: "phone",
        label: "g.phone_number",
        field: "phone",
        sortable: true,
        align: "left",
    },
    { name: "role", label: "input.role.name", field: "role", align: "left" },
    {
        name: "account",
        label: "input.account.name",
        field: "account",
        align: "left",
    },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const Accounts = [
    {
        name: "name",
        required: true,
        label: "input.account.name",
        align: "left",
        field: "name",
        sortable: true,
    },
    {
        name: "phone",
        label: "g.phone_number",
        field: "phone",
        sortable: true,
        align: "left",
    },
    {
        name: "role",
        label: "input.account.role_count",
        field: "role",
        sortable: true,
        align: "left",
    },
    {
        name: "user",
        label: "input.account.user_count",
        field: "user",
        align: "left",
    },
    {
        name: "details",
        align: "left",
        label: "g.details",
        field: "details",
        format: (val: any) => detailsText(val),
    },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const Roles = [
    {
        name: "name",
        required: true,
        label: "input.role.name",
        align: "left",
        field: "title",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "permissions",
        align: "left",
        label: "input.account.role_count",
        field: "permissions",
        format: (val: any) => `${val.length}`,
    },
    {
        name: "users",
        label: "input.account.user_count",
        field: "users",
        align: "left",
        format: (val: any) => `${val.length}`,
    },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
        sortable: true,
    },
];

export const Permissions = [
    {
        name: "details",
        required: true,
        label: "input.permission.name",
        align: "left",
        field: "details",
        sortable: true,
    },
    {
        name: "title",
        align: "left",
        label: "input.permission.url",
        field: "title",
        sortable: true,
    },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
        sortable: true,
    },
    { name: "options", label: "g.options", field: "options" },
];

export const BudgetNames = [
    {
        name: "name",
        required: true,
        label: "input.budget_name.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "details",
        align: "left",
        label: "g.details",
        field: "details",
        format: (val: any) => detailsText(val),
    },
    {
        name: "budget_type",
        align: "left",
        label: "input.budget_name.status",
        field: "budget_type",
    },
    {
        name: "budget_status",
        align: "left",
        label: "g.type",
        field: "budget_status",
    },
    {
        name: "num",
        align: "left",
        label: "input.budget_name.num",
        field: "num",
    },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
        sortable: true,
    },
    { name: "options", label: "g.options", field: "options" },
];

export const Budgets = [
    {
        name: "budget.name",
        required: true,
        label: "input.budget.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "amount",
        align: "left",
        label: "input.budget.amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
    },
    {
        name: "expense",
        align: "left",
        label: "input.budget.expense",
        field: "expense",
        format: (val: number) => formatNumber(val),
    },
    {
        name: "new_amount",
        align: "left",
        label: "المبلغ المتبقي",
        field: "new_amount",
        format: (val: number) => formatNumber(val),
    },
    { name: "knob", align: "center", label: "%", field: "knob" },
    { name: "num", align: "center", label: "input.budget.num", field: "num" },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
        sortable: true,
    },
    { name: "options", label: "g.options", field: "options" },
];

export const PrivateLockers = [
    {
        name: "name",
        required: true,
        label: "input.public.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "amount",
        align: "left",
        label: "input.all.r_amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        sortable: true,
    },
    {
        name: "problem",
        label: "input.budget.num_r",
        field: "problem",
        sortable: true,
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "on_open",
        label: "input.public.open",
        field: "on_open",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const PublicTreasuries = [
    {
        name: "name",
        required: true,
        label: "input.public.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "on_open",
        align: "left",
        label: "input.public.amount",
        field: "on_open",
        sortable: true,
    },
    {
        name: "amount",
        label: "input.public.r_amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "problem",
        label: "input.budget.num_r",
        field: "problem",
        sortable: true,
        align: "left",
    },
    { name: "user", label: "input.all.sender", field: "user", align: "left" },
    {
        name: "created_at",
        label: "input.all.send_date",
        field: "created_at",
        align: "left",
    },
    { name: "admin", label: "input.all.admin", field: "admin", align: "left" },
    {
        name: "updated_at",
        label: "input.all.r_date",
        field: "updated_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const OpenDate = [
    {
        name: "on_open",
        align: "left",
        label: "input.public.amount",
        field: "on_open",
        sortable: true,
    },
    {
        name: "amount",
        label: "input.public.r_amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "problem",
        label: "input.budget.num_r",
        field: "problem",
        sortable: true,
        align: "left",
    },
    { name: "user", label: "input.all.sender", field: "user", align: "left" },
    { name: "created_at", label: "input", field: "created_at", align: "left" },
    { name: "admin", label: "input.all.admin", field: "admin", align: "left" },
    {
        name: "updated_at",
        label: "input.all.r_date",
        field: "updated_at",
        align: "left",
    },
];

export const Expanses = [
    {
        name: "name",
        required: true,
        label: "input.expanse.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
    },
    {
        name: "amount",
        label: "input.all.amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "text_amount",
        align: "left",
        label: "input.all.amount_text",
        field: "text_amount",
        sortable: true,
    },
    {
        name: "beneficiary",
        label: "input.expanse.beneficiary",
        field: "beneficiary",
        sortable: true,
        align: "left",
    },
    { name: "user", label: "input.all.sender", field: "user", align: "left" },
    {
        name: "created_at",
        label: "input.all.send_date",
        field: "created_at",
        align: "left",
    },
    { name: "admin", label: "input.all.admin", field: "admin", align: "left" },
    {
        name: "updated_at",
        label: "input.all.r_date",
        field: "updated_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const Amount = [
    { name: "id", label: "g.id", field: "id", align: "left" },
    {
        name: "amount",
        label: "input.all.amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "take",
        align: "left",
        label: "input.all.export",
        field: "take",
        sortable: true,
    },
    {
        name: "export",
        label: "input.all.import",
        field: "export",
        sortable: true,
        align: "left",
    },
    { name: "details", label: "g.details", field: "details", align: "left" },
    {
        name: "type",
        align: "left",
        label: "input.all.type",
        field: "type",
        sortable: true,
    },
    { name: "user", label: "input.all.createBy", field: "user", align: "left" },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
];

export const Clients = [
    {
        name: "name",
        required: true,
        label: "input.client.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "amount",
        label: "input.all.r_amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "email",
        align: "left",
        label: "g.email",
        field: "email",
        sortable: true,
    },
    {
        name: "phone",
        label: "g.phone_number",
        field: "phone",
        sortable: true,
        align: "left",
    },
    { name: "roof", label: "input.client.roof", field: "roof", align: "left" },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const Suppliers = [
    {
        name: "name",
        required: true,
        label: "input.supplier.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "amount",
        label: "input.all.r_amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "email",
        align: "left",
        label: "g.email",
        field: "email",
        sortable: true,
    },
    {
        name: "phone",
        label: "g.phone_number",
        field: "phone",
        sortable: true,
        align: "left",
    },
    {
        name: "address",
        align: "left",
        label: "g.address",
        field: "address",
        format: (val: any) => detailsText(val),
    },
    { name: "user", label: "input.all.createBy", field: "user", align: "left" },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const Categories = [
    { name: "id", label: "g.id", field: "id", align: "left" },
    {
        name: "name",
        required: true,
        label: "input.category.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "details",
        label: "g.details",
        field: "details",
        sortable: true,
        align: "left",
    },
    { name: "status", label: "g.type", field: "status", align: "left" },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const Stores = [
    { name: "id", label: "g.id", field: "id", align: "left" },
    {
        name: "name",
        required: true,
        label: "input.store.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "details",
        label: "g.details",
        field: "details",
        sortable: true,
        align: "left",
    },
    {
        name: "productCount",
        label: "input.store.num",
        field: "productCount",
        align: "left",
    },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const Units = [
    { name: "id", label: "g.id", field: "id", align: "left" },
    {
        name: "name",
        required: true,
        label: "input.unit.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "num",
        label: "input.unit.num",
        field: "num",
        sortable: true,
        align: "left",
    },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const Products = [
    {
        name: "barcode",
        label: "input.product.barcode",
        field: "barcode",
        align: "left",
    },
    {
        name: "name",
        required: true,
        label: "input.product.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "amount",
        label: "input.product.amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "gain",
        align: "left",
        label: "input.product.gain",
        field: "gain",
        sortable: true,
    },
    {
        name: "price",
        label: "input.product.price",
        field: "price",
        sortable: true,
        align: "left",
    },
    {
        name: "number",
        label: "input.product.num",
        field: "number",
        align: "left",
    },
    {
        name: "number_in",
        label: "input.all.import",
        field: "number_in",
        align: "left",
    },
    {
        name: "number_out",
        label: "input.all.export",
        field: "number_out",
        align: "left",
    },
    {
        name: "category",
        label: "input.category.name",
        field: "category",
        align: "left",
    },
    {
        name: "status_label",
        label: "g.type",
        field: "status_label",
        align: "left",
    },
    {
        name: "images",
        label: "input.product.img",
        field: "images",
        align: "left",
    },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "g.options", field: "options" },
];

export const ProductsStore = [
    {
        name: "name",
        required: true,
        label: "input.product.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    {
        name: "amount",
        label: "input.product.amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "price",
        label: "input.product.price",
        field: "price",
        sortable: true,
        align: "left",
    },
    {
        name: "number",
        label: "input.product.num",
        field: "number",
        align: "left",
    },
    {
        name: "number_in",
        label: "input.all.import",
        field: "number_in",
        align: "left",
    },
    {
        name: "number_out",
        label: "input.all.export",
        field: "number_out",
        align: "left",
    },
    {
        name: "category",
        label: "input.category.name",
        field: "category",
        align: "left",
    },
    { name: "unit", label: "input.unit.name", field: "unit", align: "left" },
];

export const SupplierOrders = [
    {
        name: "amount",
        label: "g.amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "num",
        align: "left",
        label: "input.order.num",
        field: "num",
        sortable: true,
    },
    {
        name: "number",
        label: "input.product.num",
        field: "number",
        align: "left",
    },
    { name: "type", label: "input.order.type", field: "type", align: "left" },
    {
        name: "account",
        label: "input.order.account",
        field: "account",
        align: "left",
    },
    {
        name: "details",
        align: "left",
        label: "g.details",
        field: "details",
        format: (val: any) => detailsText(val),
    },
    { name: "user", label: "input.all.createBy", field: "user", align: "left" },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "", field: "options" },
];

export const Orders = [
    {
        name: "amount",
        label: "g.amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "num",
        align: "left",
        label: "input.order.num",
        field: "num",
        sortable: true,
    },
    {
        name: "number",
        label: "input.product.num",
        field: "number",
        align: "left",
    },
    { name: "type", label: "input.order.type", field: "type", align: "left" },
    {
        name: "account",
        label: "input.order.account",
        field: "account",
        align: "left",
    },
    {
        name: "details",
        align: "left",
        label: "g.details",
        field: "details",
        format: (val: any) => detailsText(val),
    },
    { name: "user", label: "input.all.createBy", field: "user", align: "left" },
    {
        name: "discount",
        label: "input.order.discount",
        field: "discount",
        align: "left",
    },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
    },
    { name: "options", label: "", field: "options" },
];

export const SupOrders = [
    {
        name: "name",
        required: true,
        label: "input.product.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    { name: "num", label: "input.product.num", field: "num", align: "left" },
    {
        name: "amount",
        label: "input.product.amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "total",
        label: "input.public.amount",
        field: "total",
        align: "left",
    },
    { name: "user", label: "input.all.createBy", field: "user", align: "left" },
    { name: "admin", label: "input.all.admin", field: "admin", align: "left" },
    {
        name: "updated_at",
        label: "input.all.type",
        field: "updated_at",
        align: "left",
    },
    { name: "options", label: "", field: "options" },
];

export const BackOrders = [
    {
        name: "name",
        required: true,
        label: "input.product.name",
        align: "left",
        field: "name",
        format: (val: any) => `${val}`,
        sortable: true,
    },
    { name: "num", label: "input.product.num", field: "num", align: "left" },
    {
        name: "price",
        label: "input.product.unit",
        field: "price",
        align: "left",
    },
    {
        name: "all_amount",
        label: "input.public.amount",
        field: "all_amount",
        align: "left",
    },
    { name: "user", label: "input.all.createBy", field: "user", align: "left" },
    { name: "admin", label: "input.all.admin", field: "admin", align: "left" },
    {
        name: "updated_at",
        label: "input.all.type",
        field: "updated_at",
        align: "left",
    },
    { name: "options", label: "", field: "options" },
];

export const LocalOrder = [
    { name: "operation", label: "g.options", field: "operation" },
    { name: "id", label: "g.id", field: "id", align: "left" },
    {
        name: "name",
        required: true,
        label: "input.product.name",
        align: "left",
        field: "name",
        format: (val: any) => detailsText(val),
    },
    { name: "store", label: "input.store.name", field: "store", align: "left" },
    {
        name: "number",
        label: "input.product.num",
        field: "number",
        align: "left",
    },
    {
        name: "amount",
        label: "input.product.amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        align: "left",
    },
    {
        name: "price",
        label: "input.product.price",
        field: "price",
        align: "left",
    },
    {
        name: "allAmount",
        label: "input.public.amount",
        field: "allAmount",
        align: "left",
    },
    { name: "options", label: "", field: "options", align: "left" },
];

export const Checks = [
    { name: "id", label: "g.id", field: "id", align: "left" },
    { name: "type", label: "g.type", field: "type", align: "left" },
    {
        name: "name",
        required: true,
        label: "input.check.name",
        align: "left",
        field: "name",
        sortable: true,
    },
    {
        name: "num",
        align: "left",
        label: "input.check.num",
        field: "num",
        sortable: true,
    },
    { name: "bank", label: "input.check.bank", field: "bank", sortable: true },
    {
        name: "amount",
        label: "g.amount",
        field: "amount",
        format: (val: number) => formatNumber(val),
        sortable: true,
    },
    {
        name: "client",
        label: "input.check.client",
        field: "client",
        sortable: true,
    },
    { name: "details", label: "g.details", field: "details" },
    { name: "user", label: "input.all.createBy", field: "user", align: "left" },
    {
        name: "created_at",
        label: "g.created_at",
        field: "created_at",
        align: "left",
        sortable: true,
    },
    { name: "options", label: "g.options", field: "options" },
];
