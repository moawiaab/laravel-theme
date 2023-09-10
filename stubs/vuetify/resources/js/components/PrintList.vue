<template>
    <div id="printMe" style="width: 100%; display: none;">
        <h1 style="text-align: center; "><b><u>{{ title }}</u></b></h1>
        <div class="invoice-box rtl">
            <data-table :headers="localHeader" :items="items" :hide-footer="true" />
        </div>
    </div>
</template>

<script>
export default {
    props: ['items', 'header', 'title'],
    setup(props) {
        const localHeader = props.header.filter((e) => e.value != "operation")
        return { localHeader }
    }
}

</script>
