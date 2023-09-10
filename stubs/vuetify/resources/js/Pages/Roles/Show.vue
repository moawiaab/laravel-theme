<template>

</template>

<script>
import { ref, computed, watch } from "vue";
import { useSingleRoles } from '../../stores/roles/single';

export default {
    name: "ShowRole",
    setup() {
        let thisModal = ref(null);
        const single = useSingleRoles();
        const showModal = computed(() => single.showModalShow);

        watch(showModal, (q) => {
            thisModal.value.show();
        }, { deep: true });
        return {
            thisModal,
            single,
        }
    },

}
</script>
