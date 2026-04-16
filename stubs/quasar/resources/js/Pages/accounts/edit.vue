<template>
    <m-dialog
        :w="30"
        v-model="table.editRow"
        :title="
            $t('input.account.title_edit') +
            ' : ' +
            (table.row.name || account.entry.name)
        "
    >
        <one-form
            @submitted="onSubmit"
            @reset="onReset"
            class="q-gutter-md"
            :loading="account.loading"
            btnLabel="g.update"
        >
                    <m-input
                        v-model="account.entry.name"
                        :label="$t('input.account.name')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        :error="account.errors.name"
                        icon="mdi-source-branch"
                    />

                    <m-input
                        v-model="account.entry.phone"
                        :label="$t('g.two_factor.phone_number')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        type="phone"
                        :error="account.errors.phone"
                        icon="phone"
                    />

                    <m-input
                        v-model="account.entry.details"
                        :label="$t('input.account.details')"
                        :rules="[(val) => !!val || $t('v.required')]"
                        type="textarea"
                        :error="account.errors.details ? true : false"
                        icon="info"
                    />
        </one-form>
    </m-dialog>
</template>

<script setup>
import { useTables } from "@/stores/tables/index";
import { useAccountIndex } from "@/stores/accounts/index";
import { useForms } from "@/Composables/Forms";
import { watch } from "vue";

const table = useTables();
const { rules: rulesData } = useForms();
const rules = rulesData;
const account = useAccountIndex();

watch(table, (e) => {
    if (e.editRow) {
        account.fetchEditData(table.row.id);
    }
});

const onSubmit = () => {
    account.updateData(table.row.id);
};

const onReset = () => {
    account.entry = {};
};
</script>

<style></style>
