<script setup>
import { useDevelopmentIndex } from "@/stores/development";
import TableForm from "./TableForm.vue";
import OneForm from "@/Components/form/OneForm.vue";
import ECard from "@/Components/Widgets/ECard.vue";


const development = useDevelopmentIndex();
development.fetchData();
</script>
<template>
    <q-page padding>
        <q-splitter
            v-model="development.splitterModel"
            style="height: 100%"
            :limits="[30, 50]"
        >
            <template v-slot:before>
                <q-separator />
                <e-card label="Controllers that change">
                    <q-chip
                        square
                        color="red-2"
                        text-color="red"
                        v-for="(item, i) in development.lists.controller_out"
                        :key="i"
                        >{{ item }}</q-chip
                    >
                </e-card>
                <q-separator />
                <e-card label="Controllers In Vendor">
                    <q-chip
                        square
                        color="blue-2"
                        text-color="blue"
                        v-for="(item, i) in development.lists.controller_in"
                        :key="i"
                        >{{ item }}</q-chip
                    >
                </e-card>
                <q-separator />

                <e-card label="Models that change ">
                    <q-chip
                        square
                        color="red-2"
                        text-color="red"
                        v-for="(item, i) in development.lists.models_out"
                        :key="i"
                        >{{ item }}</q-chip
                    >
                </e-card>
                <q-separator />

                <e-card label="Models In Vendor ">
                    <q-chip
                        square
                        color="red-2"
                        text-color="red"
                        v-for="(item, i) in development.lists.models_in"
                        :key="i"
                        >{{ item }}</q-chip
                    >
                </e-card>
                <q-separator />

                <e-card label="Resources"
                    ><q-chip
                        square
                        color="green-2"
                        text-color="green"
                        v-for="(item, i) in development.lists.resources"
                        :key="i"
                        >{{ item }}</q-chip
                    ></e-card
                ><q-separator />

                <e-card label="Requests"
                    ><q-chip
                        square
                        v-for="(item, i) in development.lists.requests"
                        :key="i"
                        >{{ item }}</q-chip
                    ></e-card
                >

                <e-card label="Tables"
                    ><q-chip
                        square
                        v-for="(item, i) in development.lists.tables"
                        :key="i"
                        >{{ item[`${development.lists.table}`] }}</q-chip
                    ></e-card
                >
                <q-separator />
            </template>

            <template v-slot:separator>
                <q-avatar
                    color="primary"
                    text-color="white"
                    size="20px"
                    icon="drag_indicator"
                />
            </template>

            <template v-slot:after>
                <q-card>
                    <q-tabs
                        v-model="development.form.tab"
                        dense
                        inline-label
                        align="justify"
                        class="text-primary shadow-2"
                        :breakpoint="0"
                    >
                        <q-tab
                            name="controller"
                            icon="mdi-gamepad-variant-outline"
                            label="Controllers"
                        />
                        <q-tab
                            name="model"
                            icon="mdi-database-refresh-outline"
                            label="Models"
                        />
                        <q-tab
                            name="resource"
                            icon="mdi-dresser-outline"
                            label="Resources"
                        />
                        <q-tab
                            name="request"
                            icon="mdi-tune-vertical"
                            label="Requests"
                        />
                    </q-tabs>

                    <q-tab-panels v-model="development.form.tab" animated>
                        <q-tab-panel name="controller">
                            <div class="q-ma-md">
                                <q-form
                                    @submit="development.storeData"
                                    @reset="onReset"
                                    class="q-gutter-md"
                                >
                                    <q-input
                                        clearable
                                        filled
                                        v-model="development.form.controller"
                                        label="Controller Name"
                                        hint="If You Like Set UserController Entre User Only"
                                        lazy-rules
                                        :rules="[
                                            (val) => !!val || $t('v.required'),
                                        ]"
                                        :error-message="
                                            development.errors.controller
                                        "
                                        :error="
                                            development.errors.controller
                                                ? true
                                                : false
                                        "
                                    />
                                    <div class="text-gary">
                                        Controller :
                                        {{
                                            development.ucFirst(
                                                development.form.controller
                                            )
                                        }}Controller
                                    </div>
                                    <div class="">
                                        Model :
                                        {{
                                            development.ucFirst(
                                                development.form.controller
                                            )
                                        }}
                                    </div>
                                    <div class="">
                                        Resource :
                                        {{
                                            development.ucFirst(
                                                development.form.controller
                                            )
                                        }}Resource
                                    </div>
                                    <div class="">
                                        Require :
                                        {{
                                            development.ucFirst(
                                                development.form.controller
                                            )
                                        }}Require
                                    </div>

                                    <q-separator />
                                    <div class="row">
                                        <div class="col q-px-sm">
                                            <q-input
                                                dense
                                                clearable
                                                filled
                                                v-model="development.entry.name"
                                                label="Column Name"
                                            >
                                            </q-input>
                                        </div>
                                        <div class="col q-px-sm">
                                            <q-select
                                                filled
                                                v-model="development.entry.type"
                                                :options="development.options"
                                                dense=""
                                                @update:model-value="
                                                    development.setType
                                                "
                                            />
                                        </div>
                                        <div class="col q-px-sm">
                                            <q-input
                                                :type="development.selectType"
                                                dense
                                                clearable
                                                filled
                                                v-model="
                                                    development.entry.value
                                                "
                                                label="Default value"
                                            >
                                                <template #after>
                                                    <q-btn
                                                        flat
                                                        icon="add"
                                                        @click="
                                                            development.addItem
                                                        "
                                                    />
                                                </template>
                                            </q-input>
                                        </div>
                                    </div>

                                    <table-form
                                        :columns="development.columns"
                                        :rows="development.form.items"
                                    >
                                    </table-form>
                                    <q-separator />
                                    <q-btn
                                        class="full-width"
                                        :label="$t('g.save')"
                                        type="submit"
                                        color="primary"
                                        :loading="development.loading"
                                    />
                                </q-form>
                            </div>
                        </q-tab-panel>
                        <q-tab-panel name="model">
                            <one-form @submitted="development.submittedData">
                                <q-input
                                    clearable
                                    filled
                                    v-model="development.form.controller"
                                    label="Model Name"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error-message="
                                        development.errors.controller
                                    "
                                    :error="
                                        development.errors.controller
                                            ? true
                                            : false
                                    "
                                />

                                <div class="row q-mb-md">
                                    <div class="col q-pr-sm">
                                        <q-input
                                            dense
                                            clearable
                                            filled
                                            v-model="development.entry.name"
                                            label="Column Name"
                                        >
                                        </q-input>
                                    </div>
                                    <div class="col q-px-sm">
                                        <q-select
                                            filled
                                            v-model="development.entry.type"
                                            :options="development.options"
                                            dense=""
                                            @update:model-value="
                                                development.setType
                                            "
                                        />
                                    </div>
                                    <div class="col q-px-sm">
                                        <q-input
                                            :type="development.selectType"
                                            dense
                                            clearable
                                            filled
                                            v-model="development.entry.value"
                                            label="Default value"
                                        >
                                            <template #after>
                                                <q-btn
                                                    flat
                                                    icon="add"
                                                    @click="development.addItem"
                                                />
                                            </template>
                                        </q-input>
                                    </div>
                                </div>


                                <table-form
                                    :columns="development.columns"
                                    :rows="development.form.items"
                                >
                                </table-form>

                                <q-btn
                                    class="full-width q-mt-md"
                                    label="create a new model only"
                                    type="submit"
                                    color="red"
                                    :loading="development.loading"
                                />
                            </one-form>
                        </q-tab-panel>
                        <q-tab-panel name="resource">
                            <one-form @submitted="development.submittedData">
                                <q-input
                                    clearable
                                    filled
                                    v-model="development.form.controller"
                                    label="Resource Name"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error-message="
                                        development.errors.controller
                                    "
                                    :error="
                                        development.errors.controller
                                            ? true
                                            : false
                                    "
                                />

                                <div class="">
                                    Resource :
                                    {{
                                        development.ucFirst(
                                            development.form.controller
                                        )
                                    }}Resource
                                </div>

                                <q-btn
                                    class="full-width q-mt-md"
                                    label="create a new resource only"
                                    type="submit"
                                    color="red"
                                    :loading="development.loading"
                                />
                            </one-form>
                        </q-tab-panel>
                        <q-tab-panel name="request">
                            <one-form @submitted="development.submittedData">
                                <q-input
                                    clearable
                                    filled
                                    v-model="development.form.controller"
                                    label="Request Name"
                                    lazy-rules
                                    :rules="[
                                        (val) => !!val || $t('v.required'),
                                    ]"
                                    :error-message="
                                        development.errors.controller
                                    "
                                    :error="
                                        development.errors.controller
                                            ? true
                                            : false
                                    "
                                />
                                <div class="">
                                    Require :
                                    {{
                                        development.ucFirst(
                                            development.form.controller
                                        )
                                    }}Require
                                </div>
                                <q-btn
                                    class="full-width q-mt-md"
                                    label="create a new request only"
                                    type="submit"
                                    color="red"
                                    :loading="development.loading"
                                />
                            </one-form>
                        </q-tab-panel>
                    </q-tab-panels>
                </q-card>
            </template>
        </q-splitter>
    </q-page>
</template>
