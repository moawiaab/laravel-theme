<template>
    <span :class="`p-1 cursor-pointer text-${color || 'primary'}`" data-bs-toggle="tooltip" data-bs-placement="top"
        :title="`${title || 'تعديل البيانات'}`">
        <i :class="`fa fa-${icon || 'edit'}`"></i>
    </span>
</template>

<script setup>
defineProps(['color', 'title', 'icon'])
</script>
<style scoped>
span {
    cursor: pointer;
    text-align: center;
    align-items: center;
}
</style>
