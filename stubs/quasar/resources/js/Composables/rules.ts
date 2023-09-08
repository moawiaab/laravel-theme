import { type LoginType, type StudentData } from "@/types"
import { ref } from "vue"
import { useI18n } from "vue-i18n"
export const useForms = () => {
    // const { t } = useI18n({})
    const login = ref<LoginType>({ email: null, password: null, remember: false, })
    const rules = {
        required: [(val: any) => (val && val.length > 0) || ('v.required')],
        selected: [(val: any) => (val != null) || 'اختر بيانات لهذا الحقل من فضلك'],
    }
    return { login, rules }
}
