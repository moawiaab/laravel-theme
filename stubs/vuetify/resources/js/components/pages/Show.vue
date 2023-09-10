<template>
    <v-dialog v-model="single.showModalShow" persistent max-width="1200" scrollable>
        <v-card>
            <v-card-title class="text-h5 text-primary">
                عرض بيانات المستخدم
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-row>
                    <v-col cols="4">
                        <v-list-item :title="single.entry.name">
                            <template v-slot:prepend>
                                <v-chip label class="ml-2" prepend-icon="mdi-account-outline"> الاسم</v-chip>
                            </template>
                        </v-list-item>
                        <v-list-item :title="single.entry.email">
                            <template v-slot:prepend>
                             <v-chip label class="ml-2" prepend-icon="mdi-email-outline">  البريد </v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item :title="single.entry.phone">
                            <template v-slot:prepend>
                             <v-chip label class="ml-2" prepend-icon="mdi-phone-outline">  رقم الهاتف </v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item :title="single.entry.role">
                            <template v-slot:prepend>
                             <v-chip label class="ml-2" prepend-icon="mdi-lock-outline">  الصلاحية</v-chip>
                            </template>
                        </v-list-item>

                        <v-list-item></v-list-item>
                    </v-col>
                    <v-divider vertical />
                    <v-col></v-col>
                </v-row>
            </v-card-text>
            <v-divider />
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red-darken-1" prepend-icon="mdi-close" variant="tonal"
                    @click="single.showModalShow = false">
                    إلغاء الأمر
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>


<script lang="ts">
import { useSingleUsers } from '../../stores/users/single';

export default {
    name: "ShowPage",
    setup() {
        const single = useSingleUsers();
        return {
            single,
        }
    },
}
</script>
