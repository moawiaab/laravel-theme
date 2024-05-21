<script setup>
import {useDevelopmentTool} from "@/stores/development/tools"

const development = useDevelopmentTool();
development.fetchData()

</script>
<template>
    <q-page padding>

        <pre>
            {{ development.lists }}
        </pre>
    </q-page>
</template>
