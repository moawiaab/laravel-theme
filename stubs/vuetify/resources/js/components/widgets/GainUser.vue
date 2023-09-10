<template>
    <div class="row mx-2">
        <div class="col-lg-3 col-6 sm-12">
            <!-- small box -->
            <div class="small-box p-1 rounded-md bg-info">
                <div class="inner">
                    <h3 class="text-lg">المبيعات</h3>

                    <p>جملة المبيعات : <span>{{ parseInt(data['itemSellPrice']) }}</span></p>
                    <p>جملة الارباح : <span>{{ parseInt(data['itemSellG']) }}</span></p>
                    <p> ارباحك في المبيعات : <span>{{ parseInt(data['items']) }}</span></p>
                    <p>-</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64">
                        <path fill="none" d="M0 0H24V24H0z" />
                        <path d="M19 3l4 5h-3v12h-2V8h-3l4-5zm-5 15v2H3v-2h11zm0-7v2H3v-2h11zm-2-7v2H3V4h9z" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6 sm-12">
            <!-- small box -->
            <div class="small-box p-1 rounded-md bg-success">
                <div class="inner">
                    <h3 class="text-lg">التسليم<sup style="font-size: 20px"></sup></h3>

                    <p>جملة المبيعات : <span>{{ parseInt(data['itemSellAmount']) }}</span></p>
                    <p>جملة الارباح : <span>{{ parseInt(data['gest']) }}</span></p>
                    <p> ارباحك في المبيعات : <span>{{ parseInt(data['selld']) }}</span></p>
                    <p>-</p>
                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64">
                        <path fill="none" d="M0 0H24V24H0z" />
                        <path d="M20 4v12h3l-4 5-4-5h3V4h2zm-8 14v2H3v-2h9zm2-7v2H3v-2h11zm0-7v2H3V4h11z" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6 sm-12">
            <!-- small box -->
            <div class="small-box p-1 rounded-md bg-warning">
                <div class="inner">
                    <h3 class="text-lg">صافي الارباح </h3>

                    <p> ارباحك في التسليم : <span>{{ parseInt(data['selld']) }}</span></p>
                    <p> ارباحك في المبيعات : <span>{{ parseInt(data['items']) }}</span></p>
                    <p> ارباحك في الاستلام : <span>{{ parseInt(data['item_com_all']) }}</span></p>
                    <p> جملة ارباحك : <span>{{ parseInt(data['items'] + data['selld'] + data['item_com_all'])
                    }}</span></p>

                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M2 12h2v9H2v-9zm3 2h2v7H5v-7zm11-6h2v13h-2V8zm3 2h2v11h-2V10zM9 2h2v19H9V2zm3 2h2v17h-2V4z" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6 sm-12">
            <!-- small box -->
            <div class="small-box p-1 rounded-md bg-danger">
                <div class="inner">
                    <h3 class="text-lg"> الربح اليومي</h3>

                    <p> ارباحك في التسليم : <span>{{ parseInt(data['d_day']) }}</span></p>
                    <p> ارباحك في المبيعات : <span>{{ parseInt(data['s_day']) }}</span></p>
                    <p> ارباحك في الاستلام : <span>{{ parseInt(data['item_com']) }}</span></p>
                    <p> جملة ارباحك اليومية : <span>{{ parseInt(data['s_day'] + data['d_day'] +
                            data['item_com'])
                    }}</span></p>

                </div>
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="64" height="64">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                            d="M17 2h3a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h3V0h2v2h6V0h2v2zm0 2v2h-2V4H9v2H7V4H5v16h14V4h-2zM7 8h10v2H7V8zm0 4h10v2H7v-2z" />
                    </svg>
                </div>
            </div>
        </div>
        <!-- ./col -->

    </div>

</template>


<script >
export default {
    props: { data: Array }
}
</script>

<style scoped>
.icon {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 64px !important;
    height: 64px !important;
}


.rounded-md {
    position: relative;
    border-radius: 10px;
    color: white;
}

.col-lg-3 {
    margin-bottom: 4px;
}
</style>
