<script lang="ts" setup>
import { useClientsIndex } from "@/stores/clients/index";

const page = useClientsIndex();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="page.amountColumns"
            :title="`${$t('input.client.title_amount2')} : ${$route.params.name}`"
            selection="multiple"
            :router="`clients/${$route.params.id}/amounts`"
            role="client-amount"
            :toggle="true"
        />
    </q-page>
</template>

<style scoped></style>
