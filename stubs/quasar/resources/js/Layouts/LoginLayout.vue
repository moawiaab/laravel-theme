<template>
    <!-- <div class=""> -->
    <q-layout
        view="lhH LpR lff"
        container
        style="height: 100vh"
        :class="$q.dark.isActive ? 'bg-grey-9 ' : 'bg-grey-2'"
    >
        <q-page-container>
            <q-page>
                <router-view />
            </q-page>
        </q-page-container>
    </q-layout>
    <!-- </div> -->
</template>

<script setup lang="ts">
import { onMounted } from "vue";
import { useAuth } from "@/stores/auth/index";
import { useQuasar } from "quasar";
const auth = useAuth();

onMounted(() => {
    const $q = useQuasar();
    $q.dark.set(auth.dark);
});
</script>
