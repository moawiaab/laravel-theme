<script lang="ts" setup>
import { usePrivateLockersIndex } from "@/stores/private-lockers/index";
import { useAmounts } from "@/stores/private-lockers/amount";

import CreateLocker from "./create.vue";
import ViewLocker from "./show.vue";
import ChildAmount from "./amount.vue";

const user = usePrivateLockersIndex();
const amount = useAmounts();
</script>

<template>
    <q-page class="">
        <data-table
            :columns="user.columns"
            :title="$t('input.locker.title')"
            selection="multiple"
            router="private-lockers"
            role="private_locker"
            :toggle="true"
            :editable="false"
        >
            <template #options="{ props }">
                <q-btn
                    icon="add_circle"
                    dense
                    flat
                    rounded
                    color="primary"
                    @click="amount.setData(props)"
                    v-if="props.child && props.toggle"
                />
            </template>
        </data-table>
        <create-locker />
        <view-locker />
        <child-amount />
    </q-page>
</template>

<style scoped></style>
