<script setup>
defineProps({
    title: String,
    display: Boolean,
    rows: Array,
    columns: Array,
    bodyStyle: String,
    headStyle: String,
    tableStyle: String,
    tableHeadStyle: String,
    tableBodyStyle: String,
    footerStyle: String,
});
</script>

<template>
    <div class="" id="printMe" style="width: 100%; display: none">
        <img
            src="./print.png"
            style="
                position: absolute;
                top: 0;
                left: 0;
                z-index: -1;
            "
        />
        <div style="margin: 220px 20px 5px 20px">
            <span style="text-align: right; font-size: 18px"> title </span>
            <span style="text-align: right; font-size: 18px"> order </span>
            <span style="text-align: left">
                <p>التاريخ</p>
                <p>الزمن</p>
            </span>
        </div>

        <div class="" :style="headStyle">
            <slot name="head" />
        </div>
        <table style="width: 100%; padding: 8px" :style="tableStyle">
            <thead>
            <tr :style="tableHeadStyle">
                <td
                    v-for="(i, id) in columns"
                    :key="id"
                    style="
                        border: 1px solid #ccc !important;
                        background: #f0f0f0 !important;
                    "
                    :style="
                        i.name == 'num' || i.name == 'id'
                            ? 'text-align: center;item-align: center  '
                            : ''
                    "
                >
                    {{ i.label }}
                </td>
            </tr>
            </thead>
            <tbody :style="tableBodyStyle">
                <slot name="body" />
            </tbody>
        </table>
        <div class="" :style="footerStyle">
            <slot name="footer" />
        </div>
    </div>
</template>

