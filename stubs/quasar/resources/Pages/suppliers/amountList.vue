<script lang="ts" setup>
import { useSuppliersIndex } from "@/stores/suppliers/index";

const page = useSuppliersIndex();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="page.amountColumns"
            :title="`${$t('input.supplier.title_amount2')}: ${$route.params.name}`"
            selection="multiple"
            :router="`suppliers/${$route.params.id}/amounts`"
            role="client"
            :toggle="true"
        />
    </q-page>
</template>

<style scoped></style>
