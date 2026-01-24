<template>
  <m-dialog
    v-model="table.showRow"
    :title="$t('input.user.view') + ' : ' + (table.row.name || user.entry.name)"
    :mh="100"
  >
    <q-card>
      <widgets-bar />
      <q-card-section class="q-pt-none">
        <q-splitter v-model="table.splitterModel" style="height: 100%">
          <template v-slot:before>
            <div class="q-pa-sm">
              <q-list>
                <q-item>
                  <q-item-label
                    >{{ $t("input.user.name") }} :
                    {{ single.entry.name }}</q-item-label
                  >
                </q-item>
              </q-list>
            </div>
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
            <div class="q-pa-sm">details</div>
          </template>
        </q-splitter>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right" class="bg-white text-teal">
        <q-btn flat :label="$t('g.close')" v-close-popup color="negative" />
      </q-card-actions>
    </q-card>
  </m-dialog>
</template>

<script setup lang="ts">
import { useTables } from "@/stores/tables/index";
import { useUsersIndex } from "@/stores/users/index";
import { watch } from "@vue/runtime-core";

const table = useTables();

const single = useUsersIndex();

watch(table, (e) => {
  if (e.showRow) {
    single.fetchShowData(table.row.id);
  }
});
</script>

<style></style>
