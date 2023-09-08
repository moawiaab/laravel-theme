<script lang="ts" setup>
import { useAccountIndex } from "@/stores/accounts/index";
import CreateAccount from "./create.vue";
import EditAccount from "./edit.vue";
import ViewAccount from "./view.vue";

const account = useAccountIndex();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="account.columns"
            :title="$t('input.account.title')"
            selection="multiple"
            router="accounts"
            role="account"
            :expand="true"
            :deletable="false"
            :toggle="true"
        >
            <template #table-body="{ props }">
                <q-splitter
                    v-model="account.splitterModel"
                    style="height: 100%"
                >
                    <template v-slot:before>
                        <div class="q-pa-sm">
                            <q-card-section>
                                {{ $t("input.account.roles") }}
                            </q-card-section>

                            <div class="row">
                                <q-chip
                                    icon="link"
                                    color="red-1"
                                    text-color="red"
                                    square
                                    class="col-auto glossy"
                                    v-for="({ role }, id) in props.row.roles"
                                    :key="id"
                                >
                                    {{ role }}</q-chip
                                >
                            </div>
                        </div>
                    </template>

                    <template v-slot:separator>
                        <q-avatar
                            color="primary"
                            text-color="white"
                            size="20px"
                            icon="drag_indicator"
                        />
                    </template>

                    <template v-slot:after>
                        <div class="q-pa-sm">
                            <q-card-section>
                                {{ $t("input.account.users") }}
                            </q-card-section>

                            <div class="row">
                                <q-chip
                                    icon="person"
                                    color="blue-1"
                                    text-color="blue"
                                    square
                                    class="col-auto glossy"
                                    v-for="({ user }, id) in props.row.users"
                                    :key="id"
                                >
                                    {{ user }}</q-chip
                                >
                            </div>
                        </div>
                    </template>
                </q-splitter>
            </template>
        </data-table>

        <create-account />
        <edit-account />
        <view-account />
    </q-page>
</template>

<style scoped></style>
