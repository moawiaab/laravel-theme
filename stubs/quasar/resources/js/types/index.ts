export interface LoginType {
    email: string | null;
    password: string | null;
    remember: boolean | false,
}

export interface Accounts {
    id: number | null;
    name: string | null;
    details: string | null;
    user: string | null;
    phone: string | null;
    role: string | null;
    created_at: Date | null;
}

export interface User {
    id: number | null;
    name: string | null;
    email: string | null;
    phone: string | null;
    role: string | null;
    created_at: Date | null;
}


export interface Role {
    title: string | null;
    permissions: [];
    users: [];
}

export interface OptionsValue {
    value: number,
    label: string,
}

export interface Permission {
    title: string,
    details: string,
}

export interface BudgetName {
    name: string | null,
    details: string | null,
    type: number | null
}

export interface Budget {
    id: number | null,
    name: string | null,
    amount: number,
    budget_id: number | null,
    expense: number
}


export interface PrivateLocker {
    value: any;
    id: number | null;
    name: string | null;
    amount: number | null;
    user_id: number | null;
    account_id: number | null;
    created_at: Date | null;
}

export interface Expanse {
    id: number | null;
    name: string | null;
    amount: number | null;
    user_id: number | null;
    account_id: number | null;
    created_at: Date | null;
}

export interface Setting {
    exp_roof: boolean,
    exp_conf: boolean,
}

export interface Client {
    value: any;
    id: number | null,
    name: string | null,
    amount: number,
    budget_id: number | null,
    expense: number,
    type: number,
    roof: number,
}

export interface Supplier {
    value: any;
    id: number | null,
    name: string | null,
    amount: number,
    budget_id: number | null,
    address: string | null,
}

export interface Category {
    id: number | null,
    name: string | null,
}

export interface Unit {
    id: number | null,
    name: string | null,
}
export interface Store {
    id: number | null,
    name: string | null,
}
export interface Product {
    barcode: number | null,
    id: number | null,
    name: string | null,
    amount: number | null,
    gain: number | null,
    price: number | null,
    status: number | null,
    store_id: number | null,
    number: number | null,
    store: number | null,
}

export interface SupplierOrder {
    id: number | null,
    amount: number | null,
}

export interface Check {
    id: number | null,
    amount: number | null,
}
export interface StudentData {
    id: number | null;
    name: string | null;
    age: string | null;
    email: string | null | any;
    phone: string | null;
    password: string | null;
    password_confirmation: string | null;
    details: string | null;
    type: number | null;
    level_id: number | null;
    photo: File | null;
    levelClass: Array<[]> | null;
}
