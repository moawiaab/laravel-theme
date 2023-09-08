import { ref } from "vue"
import { type LoginType, type StudentData } from "@/types"
import { useI18n } from "vue-i18n";
import messages from "@/i18n/index";
import { useAuth } from "@/stores/auth";

export const useForms = () => {
    const { t } = useI18n({
        locale : useAuth().quasarLang,
        messages
    });
    const login = ref<LoginType>({ email: null, password: null, remember: false, })
    const rules = {
        required: [(val: any) => !!val || t('v.required')],
        selected: [(val: any) => (val != null) || t('v.selected')],
    }
    return { login, rules }
}
