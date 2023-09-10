export default {
    app_title: 'برنامج المبيعات',
    failed: 'العملية فشلة',
    success: 'تم العملية بنجاح',
    input: {
        list: {
            cash: "نقداً",
            bankak: "بنكك",
            card: "بطاقة صراف",
            order: 'مبلغ فاتورة',
            check: 'شيك',
            other: "اخرى"
        },
        all: {
            email: 'البريد الالكتروني * ',
            password: 'كلمة السر *',
            amount: 'المبلغ',
            amount_text: 'المبلغ نصاً',
            sender: 'المرسل',
            send_date: 'تاريخ الارسال ',
            admin: 'المستلم',
            r_date: 'تاريخ الاستلام',
            createBy: 'تم الإنشاء بواسطة',
            r_amount: 'الرصيد',
            export: 'الوارد',
            import: 'الصادر',
            type: "طريقة الاستلام ",
            back: 'راجع'
        },
        account: {
            title: 'قائمة الفروع',
            title_new: 'إنشاء فرع جديد',
            title_edit: 'تعديل بيانات الفرع',
            view: 'عرض بيانات الفرع',
            roles: 'الأذونات لهذه الصلاحية',
            users: 'المستخدمين لهذه الصلاحية',
            name: 'اسم الفرع ',
            details: 'تفاصيل الفرع',
            description: 'وصف الفرع',
            admin: 'مدير الفرع',
            beneficiary: 'المستفيد ',
            role_count: 'عدد الصلاحيات',
            user_count: 'عدد المستخدمين',
        },
        expanse: {
            title: 'قائمة المصروفات',
            title_new: 'إنشاء مصروف جديد',
            title_edit: 'تعديل بيانات المصروف',
            view: 'عرض بيانات المصروف',
            amount: ' المبلغ المراد صرفه *',
            name: ' بند الصرف',
            details: 'تفاصيل الصرفة',
            r1: 'ادخل المبلغ لو سمحت',
            r2: 'لقد تجاوزت الحد المسموح به من هذا البند',
            beneficiary: 'المستفيد'
        },
        client: {
            title: 'قائمة العملاء',
            title_new: 'إنشاء عميل جديد',
            title_edit: 'تعديل بيانات العميل',
            title_amount: 'توردات العميل ',
            title_amount2: ' التوردات المالية للعميل ',
            view: 'عرض بيانات العميل',
            roof: 'السقف المسموح',
            name: "اسم العميل",
            type: 'حالة العميل',
            r1: 'اخر خمس واردات لهذا العميل',
            r2: 'عرض مزيد من المعاملات ...',
            status0: 'اضافة مبلغ الى العميل',
            status1: 'خصم مبلغ من العميل',
            v1: 'ادخل المبلغ لو سمحت',
            v2: 'لقد تجاوزت السقف المسموح به لهذا العميل',
            check_name: 'اسم صاحب الشيك',
            check_num: 'رقم الشيك',
            check_bank: 'اسم البنك',
            check_date: 'تاريخ الشيك'
        },
        supplier: {
            title: 'قائمة الموردين',
            title_new: 'إنشاء مورد جديد',
            title_edit: 'تعديل بيانات المورد',
            title_amount: 'توردات المورد ',
            title_amount2: ' التوردات المالية للمورد ',
            view: 'عرض بيانات المورد',
            roof: 'السقف المسموح',
            name: "اسم المورد",
            type: 'حالة المورد',
            r1: 'اخر خمس واردات لهذا المورد',
            r2: 'عرض مزيد من المعاملات ...',
            status0: 'اضافة مبلغ الى المورد',
            status1: 'خصم مبلغ من المورد',
            v1: 'ادخل المبلغ لو سمحت',
            v2: 'لقد تجاوزت السقف المسموح به لهذا المورد'
        },
        budget: {
            title: 'قائمة الموازنة المالية',
            title_new: 'إنشاء بند موازنة جديد',
            title_edit: 'تعديل بيانات بند الموازنة',
            view: 'عرض بيانات بند الموازنة',
            name: ' بند الموازنة',
            amount: 'المبلغ المحدد',
            expense: 'المبلغ المصروف',
            num: "عدد المعاملات",
            num_r: "الباقي من المبلغ",
        },
        budget_name: {
            title: 'قائمة اسماء الموازنة',
            title_new: 'إنشاء اسم موازنة جديد',
            title_edit: 'تعديل بيانات اسم الموازنة',
            view: 'عرض بيانات اسم الموازنة',
            name: ' اسم الموازنة',
            // amount: 'المبلغ المحدد',
            num: "عدد الموازنات",
            status: "حالة الموازنة",
        },
        public: {
            title: 'الخزنة العامة',
            name: 'صاحب الخزنة',
            open: "عند فتح الخزنة",
            amount: "جملة المبلغ",
            r_amount: 'المبلغ المحول'
        },
        locker: {
            title: ' الخزائن الشخصية',
            title_new: 'فتح خزنة شخصية ',
            view: 'ارسال مبلغ الى الخزنة العامة',
        },
        store: {
            title: 'قائمة المخازن',
            title_new: 'انشاء مخزنة جديد ',
            title_edit: 'تعديل بيانات المخزن',
            view: 'عرض بيانات المخزن ',
            name: 'اسم المخزن',
            num: 'عدد المنتجات'
        },
        order: {
            title: 'قائمة فواتير المبيعات',
            title_new: 'انشاء فاتورة مبيعات ',
            title_edit: 'تعديل بيانات المخزن',
            num: 'عدد المنتجات',
            type: "نوع الفاتورة",
            account: ' جهة الفاتورة',
            discount: 'التخفيض',
            local_m: 'قائمة الأصناف فارغة اضف اصناف الى الجدول ثم ارسلها الى السيرفر',
            selectProduct: 'اختر المنتج من هنا',
            store: 'اختر المخزن',
            add: 'إضافة المنتج الى الفاتورة',
            s0: 'نقداً حالي (عاجل)',
            s1: 'دين (آجل)',
            amount_add: 'المبلغ المدفوع',
            date: 'تاريخ السداد',
            details: 'تفاصيل الفاتورة ان وجد ...',
            send: 'ارسال البيانات الى السيرفر',
            r1: 'تسليم الصنف',
            r2: 'سيتم تسليم الصنف وخصم الكمية من المخزن المحدد مسبقا في انشاء الفاتورة',
            r3: 'تسليم جميع الأصناف',
            r4: 'سيتم تسليم جميع الأصناف وخصمها من المخزن المحدد مسبقا في انشاء الفاتورة',
            r5: 'ارجاع جميع الأصناف',
            r6: 'سيتم ارجاع جميع الأصناف من الفاتورة',
            r7: 'ارجاع الصنف',
            r8: ' سيتم ارجاع الصنف من الفاتورة'
        },

        product: {
            title: 'قائمة المنتجات',
            title_new: 'إنشاء منتج جديد',
            title_edit: 'تعديل بيانات المنتج',
            view: 'عرض بيانات المنتج',
            name: 'اسم المنتج',
            num: 'الكمية',
            amount: 'سعر الشراء',
            price: 'سعر البيع',
            gain: 'نسبة الربح',
            unit: 'سعر الوحدة',
            barcode: 'الباركود',
            img: 'الصورة',
            s0: 'منتج خاص بهذا الفرع لا يظهر في بقية الفروع',
            s1: 'منتج عام يظهر اسم المنتج في بقية الفروع ',

        },
        supOrder: {
            title: 'قائمة فواتير المشتريات',
            s0: 'من الشركات والموردين',
            s1: 'من العملاء',
        },
        back: {
            title: 'قائمة فواتير المرتجات',
            o1: 'المرتجعات الغير المستلم',
            o2: "المرتجعات المستلمة",
            t1: 'استلام المرتج',
            t2: ' سيتم استلام المرتجع إضافتها الى المخزن المحدد مسبقا في انشاء الفاتورة',
        },
        category: {
            title: 'قائمة أقسام المنتاجت',
            title_new: 'تعديل بيانات القسم ',
            title_edit: 'إنشاء قسم جديد',
            view: 'عرض بيانات القسم ',
            name: 'اسم القسم',
            s0: ' قسم خاص',
            s1: ' قسم عام',
            r1: ' اخر خمس منتجات لهذا القسم',
        },
        unit: {
            title: 'قائمة وحدات المنتاجت',
            title_new: 'تعديل بيانات الوحدة ',
            title_edit: 'إنشاء وحدة جديدة',
            name: 'اسم الوحدة',
            num: 'عدد الوحدات'
        },
        user: {
            title: 'قائمة المستخدمين',
            title_new: 'انشاء مستخدم جديد ',
            title_edit: 'تعديل بيانات المستخدم',
            view: 'عرض بيانات المستخدم',
            name: 'اسم المستخدم',
            role: 'الصلاحية'
        },
        role: {
            title: 'قائمة الصلاحيات',
            title_new: 'انشاء صلاحية جديد ',
            title_edit: 'تعديل بيانات الصلاحية',
            name: 'اسم الصلاحية',
            user: 'المستخدمين لهذه الصلاحية ',
            role: ' الأذونات لهذه الصلاحية '
        },
        permission: {
            title: 'قائمة الأذونات',
            title_new: 'انشاء إذن جديد ',
            title_edit: 'تعديل بيانات الإذن',
            name: 'اسم الإذن',
            url: 'رباط الصلاحية'
        },
        report: {
            date: 'تاريخ التقرير',
            user: 'تقرير حسب المستخدمين',
            w1: 'جملة المبيعات',
            w2: 'وارد العملاء',
            w3: 'وارد الشركات',
            w4: 'صادر العملاء',
            w5: 'صادر الموردين',
            w6: 'صافي الخزنة اليومية',
            order1: 'فواتير المبيعات ليوم',
            a1: 'المعاملات المالية للعملاء',
            a2: 'المعاملات المالية للشركات والموردين',
            a3: 'المرتجعات',

            c1: 'تاريخ البداية',
            c2: 'تاريخ النهاية',
            c3: 'تقرير حسب الفرع',
            c4: 'جملت المصروفات في هذه الفترة',
            c5: 'جملت الأرباح في هذه الفترة',
            c6: 'صافي الربح',
            c7: 'الجرد الحقيقي للمنتجات',
            c8: 'المنتجات مع الربح المتوقع',
            c9: 'الربح المتوقع',
            c10: 'المبلغ المطلوب من العملاء (مدين)',
            c11: 'مبلغ للعملاء (دائن)',
            c12: 'صافي معاملات العملاء المالية',
            c13: 'المبلغ المطلوب من الموردين (مدين)',
            c14: 'مبلغ للموردين (دائن)',
            c15: 'صافي معاملات الموردين المالية'
        },
        check: {
            title: 'قائمة الشيكات',
            name : 'صاحب الشيك',
            num : 'رقم الشيك',
            bank : "البنك",
            client : 'العميل/المورد',
            in: 'الشيكات الدخالة',
            out : 'الشيكات الخارجة',
            last : 'النتيجة'
        },
    },
    g: {
        type: 'الحالة',
        details: 'التفاصيل',
        options: 'الخيارات',
        id: 'الكود',
        email: 'البريد',
        amount_text: 'المبلغ نصاً',
        actions: 'العمليات',
        add: 'إضافة',
        allRightsReserved: 'كافة الحقوق محفوظة',
        areYouSure: 'هل أنت متأكد؟',
        clickHereToVerify: 'اضغط هنا للتحقق',
        create: 'إضافة',
        dashboard: 'الرئيسية',
        delete: 'حذف',
        cancel: 'إلغاء',
        clear: 'مسح',
        downloadFile: 'تحميل الملف',
        edit: 'تعديل',
        emailVerificationSuccess: 'تم التحقق من بريد المستخدم الإلكتروني بنجاح',
        entries: 'المدخلات',
        filterDate: 'فرز حسب التاريخ',
        forgot_password: 'نسيت كلمة المرور؟',
        home: 'الرئيسية',
        list: 'قائمة',
        login: 'تسجيل الدخول',
        login_email: 'البريد الالكتروني',
        login_password: 'كلمة المرور',
        login_password_confirmation: 'تأكيد كلمة المرور',
        logout: 'تسجيل خروج',
        month: 'الشهر',
        no: 'لا',
        pleaseSelect: 'الرجاء الإختيار',
        register: 'سجل',
        remember_me: 'تذكرني',
        reset_password: 'إعادة تعيين كلمة المرور',
        send_password: 'إرسال رابط إعادة تعيين كلمة المرور',
        save: 'حفظ',
        search: 'بحث',
        searching: 'جاري البحث',
        no_results: 'لايوجد نتائج',
        results_could_not_be_loaded: 'لايمكن تحميل النتائج',
        search_input_too_short: 'الرجاء إدخال: عدد أو أكثر من الحروف',
        show: 'عرض',
        systemCalendar: 'التقويم',
        thankYouForUsingOurApplication: 'شكرا لزيارتك لموقعنا',
        timeFrom: 'من',
        timeTo: 'إلى',
        toggleNavigation: 'تبديل الملاحة',
        user_name: 'اسم المستخدم',
        verifyYourEmail: 'يرجى تأكيد بريد الالكتروني',
        verifyYourUser: 'لإنهاء التسجيل - يطلب منك الموقع التحقق من بريدك الإلكتروني',
        view: 'عرض',
        view_file: 'عرض الملف',
        year: 'السنة',
        yes: 'نعم',
        youAreLoggedIn: 'تم تسجيل الدخول',
        yourAccountNeedsAdminApproval: 'يحتاج حسابك إلى موافقة المسؤول من أجل تسجيل الدخول',
        submit: 'إرسال',
        relatedData: 'بيانات ذات صلة',
        update_profile_success: 'تم تعديل الملف الشخصي بنجاح',
        change_password_success: 'تم تغير كلمة المرور بنجاح',
        delete_account_success: 'تم حذف الحساب بنجاح',
        saved: 'تم الحفظ',
        profile_information: 'معلومات الملف الشخصي',
        all_messages: 'جميع الرسائل',
        new_message: 'رسالة جديدة',
        messages: 'رسائل',
        inbox: 'الوارد',
        outbox: 'الصادر',
        subject: 'العنوان',
        recipients: 'المستلمون',
        from: 'من',
        to: 'إلى',
        reply: 'الرد',
        body: 'المحتوى',
        discard: 'تجاهل',
        datatables: {
            copy: 'نسخ',
            csv: 'CSV',
            excel: 'إكسل',
            pdf: 'PDF',
            print: 'طباعة',
            colvis: 'الاعمدة',
            delete: 'حذف المحدد',
            zero_selected: 'لم يتم تحديد صفوف',
        },
        billing: {
            menu: 'الفوترة',
            current_plan: 'اشتراكك الحالي',
            choose_this_plan: 'اختر هذا الاشتراك',
            month: 'شهر',
            trial_user: 'مستخدم تجريبي',
            plan_purchased_successfully: 'تم شراء هذا الاشتراك بنجاح',
        },
        payments: {
            title: 'المدفوعات',
            payment_date: 'تاريخ الدفع',
            amount: 'القيمه',
        },
        table: 'جدول',
        back: 'رجوع',
        refresh: 'تحديث',
        close: 'إغلاق',
        create_success: 'تمت عملية التخزين  بنجاح.',
        update_success: 'تمت عملية التعديل بنجاح.',
        delete_success: 'تم الحذف  بنجاح',
        action: 'العملية',
        action_id: 'رقم العملية',
        action_model: 'نموذج العملية',
        address: 'العنوان',
        administrator_can_create_other_users: 'فقط (المدير (يستطيع إنشاء مستخدمين اخرين',
        aggregate_function_use: 'دالة تجميع لاستخدام',
        all: 'الكل',
        amount: 'القيمة',
        answer: 'إجابة',
        app_csv_file_to_import: 'ملف CSV للاستيراد',
        app_csvImport: 'استيراد ملف CSV',
        app_file_contains_header_row: 'يحتوي الملف على عنوان الصف؟',
        app_import_data: 'استيراد بيانات',
        app_imported_rows_to_table: 'تم استيراد :rows  صفوف إلى الجدول : table',
        app_parse_csv: 'تحليل CSV',
        asset: 'شحنة',
        assets: 'الشحنات',
        assets_history: 'التوزيع',
        assets_management: 'الشحنات',
        assigned_to: 'مخصص ل',
        assigned_user: 'تعيين المستخدم',
        attachment: 'المرفق',
        axis: 'محور',
        back_to_list: 'الرجوع للقائمة',
        basic_crm: 'إداره علاقات العملاء',
        budget: 'الميزانية',
        calendar_sources: 'مصدر التقويم',
        campaign: 'الحملة',
        campaigns: 'الحملات',
        categories: 'الفئات',
        category: 'الفئة',
        category_name: 'إسم الفئة',
        change_notifications_field_1_label: 'إرسال إشعار بالبريد الإلكتروني إلى المستخدم',
        change_notifications_field_2_label: 'وقت إدخال سجل',
        my_profile: 'حسابي',
        change_password: 'تغيير كلمة المرور',
        delete_account: 'حذف الحساب',
        delete_account_warning: 'ادخل الايميل الخاص بك لتأكيد أنك تريد حذف الحساب - هذا الإجراء لا يمكن التراجع عنه',
        two_factor: {
            title: 'المصادقة الثنائية',
            sub_title: 'تم إرسال رمز المصادقة الثنائية عبر البريد الإلكتروني. الكود صالح لمدة: دقيقة. إذا لم تستلمها ، اضغط على إعادة الإرسال.',
            code: 'رمز المصادقة الثنائية',
            does_not_match: 'رمز المصادقة الثنائية الذى ادخلته غير صحيح',
            sent_again: 'تم إرسال رمز المصادقة الثنائية مرة أخرى',
            expired: 'انتهت صلاحية رمز المصادقة الثنائية. الرجاد اعادة الدخول.',
            enabled: 'تم تفعيل خاصية المصادقة الثنائية بنجاح',
            disabled: 'تم تعطيل خاصية المصادقة الثنائية',
            your_code_is: 'كود المصادقة الثنائية هو:',
            will_expire_in: 'ستنتهي صلاحية الرمز خلال: دقائق.',
            ignore_this: 'إذا لم تحاول تسجيل الدخول ، فتجاهل هذه الرسالة.',
            verify_here: 'تحقق هنا',
            verify: 'تحقق',
            phone_number: 'رقم الهاتف',
            enable: 'تفعيل',
            disable: 'تعطيل',
            resend: 'إعادة إرسال',
        },
        chart_type: 'نوع الرسم البياني',
        code: 'كود',
        companies: 'الشركات',
        company: 'الشركة',
        company_name: 'إسم الشركة',
        confirm_password: 'تأكيد كلمة المرور',
        contact_management: 'إدارة بيانات الاتصال',
        contacts: 'المتصلين',
        content_management: 'إدارة المحتوى',
        copy_paste_url_bellow: 'انسخ الرابط أدناه وألصقه في متصفح الويب:',
        country: 'الدولة',
        coupon_management: 'إدارة القسيمة',
        coupons: 'قسائم',
        coupons_amount: 'قيمة القسيمة',
        create_new_calendar_source: 'إنشاء مصدر جديد للتقويم',
        create_new_notification: 'إنشاء تنبيه جديد',
        create_new_report: 'إنشاء تقرير جديد',
        created_at: 'تم الإنشاء في',
        crud_date_field: 'نوع تاريخ ال CRUD',
        crud_event_field: 'حقل تسمية الحدث',
        crud_title: 'عنوان الصفحة',
        csv_file_to_import: 'إستيراد من ملف CSV',
        csvImport: 'إستيراد من CSV',
        current_password: 'كلمة المرور الحالية',
        custom_controller_index: 'مؤشر تحكم مخصص',
        customer: 'العميل',
        customers: 'العملاء',
        deleted_at: 'الغيت في',
        description: 'الوصف',
        deselect_all: 'عدم تحديد الكل',
        discount_amount: 'مبلغ الخصم',
        discount_percent: 'نسبة الخصم',
        due_date: 'تاريخ الإستحقاق',
        edit_calendar_source: 'تعديل مصدر التقويم',
        email_greet: 'مرحباً',
        email_line1: 'أنت تتلقى هذه الرسالة الإلكترونية لأننا تلقينا طلب إعادة تعيين كلمة المرور لحسابك.',
        email_line2: 'إذا لم تطلب إعادة تعيين كلمة المرو، فلا يلزم اتخاذ أي إجراء آخر.',
        email_regards: 'مع التحية',
        end_time: 'نهاية الوقت',
        entry_date: 'ادخال الوقت',
        excerpt: 'ما عدا',
        faq_management: 'الأسئلة المكررة',
        featured_image: 'صورة مميزة',
        fee_percent: 'نسبة العمولة',
        file: 'الملف',
        file_contains_header_row: 'يحتوي الملف على عنوان لصف الصفحة؟',
        first_name: 'الإسم الأول',
        group_by: 'مجموعة من',
        if_you_are_having_trouble: 'إذا كنت تواجه مشكلة في النقر على',
        import_data: 'إستيراد البيانات',
        imported_rows_to_table: 'تم استيراد :rows صف :table جدول',
        integer_float_placeholder: 'يرجى تحديد واحد من الحقول رقم صحيح او يحتوي علي فاصله',
        is_created: 'إنشاء في',
        is_deleted: 'حذف في',
        is_updated: 'تعد ل في',
        label_field: 'حقل التصنيف',
        last_name: 'الإسم الأخير',
        location: 'الموقع',
        locations: 'المواقع',
        main_currency: 'العملة الرئيسية',
        message: 'الرسالة',
        name: 'الاسم',
        new_calendar_source: 'إنشاء مصدر جديد للرزنامة',
        new_password: 'الرقم السري الجديد',
        no_calendar_sources: 'لا يوجد مصدر للرزنامة بعد',
        no_entries_in_table: 'لا توجد بيانات في الجدول',
        no_reports_yet: 'لا يوجد تقارير',
        not_approved_p: 'لم تتم الموافقة على حسابك من قبل المشرف. يرجى الانتظار وإعادة المحاولة لاحقا',
        not_approved_title: 'لم يتم الموافقة عليك',
        note_text: 'الملاحظة',
        notifications: 'اشعارات',
        notify_user: 'تعديل العضو',
        pages: 'صفحات',
        parse_csv: 'تحليل CSV',
        permadel: 'حذف نهائي',
        phone: 'الهاتف',
        phone1: 'الهاتف 1',
        phone2: 'الهاتف 2',
        photo: 'صورة (بحد أقصى 8 ميغابايت)',
        photo1: 'صور 1',
        photo2: 'صور 2',
        photo3: 'صور 3',
        phone_number: 'رقم الهاتف',
        prefix: 'المسبوق',
        price: 'السعر',
        product_management: 'المنتجات',
        product_name: 'إسم المنتج',
        products: 'المنتجات',
        question: 'سؤال',
        questions: 'الأسئلة',
        recipient: 'المستلم',
        redeem_time: 'استرداد الوقت',
        registration: 'تسجيل',
        remember_token: 'كود التذكير',
        reports_x_axis_field: 'يرجى اختيار واحد من حقول',
        reports_y_axis_field: 'الرجاء اختيار واحد من حقول',
        reset_password_woops: '<strong> عذرا! /strong> حدثت مشكلات في الإدخال:',
        restore: 'استرجاع',
        sample_answer: 'نموذج إجابة',
        sample_category: 'نموذج قسم',
        sample_question: 'نموذج سؤال',
        select_all: 'تحديد الكل',
        select_crud_placeholder: 'الرجاء اختيار واحد من CRUDs الخاص بك',
        select_dt_placeholder: 'يرجى تحديد أحد حقول التاريخ / الوقت',
        select_users_placeholder: 'يرجى اختيار احد المستخدمين',
        send: 'ارسال',
        serial_number: 'الرقم التسلسلي',
        simple_user: 'مستخدم عادي',
        skype: 'سكايب',
        slug: 'رابط',
        start_date: 'بداية التاريخ',
        start_time: 'بداية الوقت',
        status: 'حالة',
        statuses: 'حالات',
        stripe_transactions: 'عمليات Stripe',
        subscriptionbilling: 'الإشتراكات',
        subscriptionpayments: 'الدفع',
        suffix: 'لاحقة',
        tag: 'وسم',
        tags: 'أوسمه',
        task_management: 'المهام',
        tasks: 'مهام',
        teammanagement: 'الفريق',
        text: 'نص',
        there_were_problems_with_input: 'كانت هناك مشاكل مع المدخلات',
        time: 'الوقت',
        title: 'العنوان',
        transaction_date: 'تاريخ الحوالة',
        trash: 'المحذوفات',
        update: 'تحديث',
        updated_at: 'التحديث في',
        upgrade_to_premium: 'الترقية إلى بريميوم',
        user_actions: 'عمليات المستخدم',
        valid_from: 'صالح من تاريخ',
        valid_to: 'صالح إلى تاريخ',
        website: 'الموقع الإلكتروني',
        when_crud: 'من CRUD',
        whoops: 'عذراً',
        x_axis_field: 'محور-اكس تاريخ او الوقت',
        x_axis_group_by: 'محور-اكس مجمعة لي',
        y_axis_field: 'محور-واي حقل',
        you_have_no_messages: 'ليس لديك أي رسالة',
        content: 'المحتوي',
        no_alerts: 'لا يوجد تحذيرات',
        test_answers: 'أجوبة الاختبار',
        test_results: 'نتائج الاختبار',
        question_options: 'خيارات السؤال',
        tests: 'الاختبارات',
        lessons: 'الدروس',
        courses: 'الدورات',
        teammembers: 'اعضاء الفريق',
        calendar: 'التقويم',
        messenger: 'مراسل',
        reset: 'تفريغ الحقول',
        max: 'تكبير',
        min: 'تصغير',
        m: {
            profile: ' الصفحة الشخصية',
            password: ' تغيير كلمة السر',
            setting: ' إعدادات النظام',
        }
    },
    v: {
        required: 'هذا الحقل مطلوب .',
        selected: 'اختر بيانات لهذا الحقل من فضلك'
    },
    d: {
        t1: 'ادخل سبب رفض الإستلام من فضلك',
        c: 'إلغاء',
        amount: 'استلام المبلغ',
        t2: ' هل تريد استلام هذا المبلغ بالفعل (سيتم خصم المبلغ من الخزنة العامة)',
        ok: 'تنفيذ الأمر',
        back: 'تأكيد الارجاع',
        d: 'تأكيد الحذف',
        delete1: 'هل تريد نقل البيانات الى سلة المهملات',
        delete2: ' هل تريد حذفه من الارشيف نهائيا',
        t3: 'هل تريد استلام هذا المبلغ بالفعل (سيتم إضافة المبلغ الى الخزنة العامة)',
        t4: 'استلام الصنف',
        t5: 'سيتم استلام الصنف وإضافتها الى المخزن المحدد مسبقا في انشاء الفاتورة',
        t6 :'استلام جميع المنتجات',
        t7 : 'هل تريد استلام جميع المنتجات واضافة الى المخازن المحددة مسبقا'
    },
    item: {
        account: 'الفروع',
        expanse: 'المصروفات',
        client: 'العملاء',
        supplier: "الموردين والشركات",
        financial_management: "المالية العامة",
        budget: 'الموازنة',
        budget_name: "اسماء الموازنة",
        public_treasury: "الخزنة العامة",
        private_locker: "الخزانات الشخصية",
        stage: "السنة المالية (المراحل)",
        store: 'المخازن',
        order_management: "إدارة الفواتير",
        order: "فواتير المبيعات",
        supplier_order: "فواتير المشتريات",
        back: "فواتير المرتجعات",
        product_management: "إدارة المنتجات",
        category: "أقسام المنتجات",
        product: 'المنتجات',
        unit: 'الوحدات',
        user_management: 'إدارة المستخدمين',
        user: 'المستخدمين',
        role: 'الصلاحيات',
        permission: 'الأذونات',
        report: 'التقارير',
        report1: "تقرير معاملات المستخدمين",
        report2: "تقرير الارباح",
        check : "الشيكات",
    },
    w: {
        users: 'عدد المستخدمين',
        user: 'مستخدم',
        products: 'عدد المنتجات',
        product: 'منتج',
        clients: 'عدد العملاء',
        client: 'عميل',
        stores: 'عدد المخازن',
        store: 'مخزن',
    },
    f: {
        add: 'إضافة صف جديد',
        refresh: 'تحديث البيانات',
        reset: 'إعادة تحميل البيانات',
        exile: 'تنزيل البيانات اكسل',
        d: 'الذهاب الى الرئيسية'
    },
    table: {
        d: 'غير محذوف',
        only: 'محذوف فقط',
        with: 'كل البيانات معا',
        new: 'الجديد فقط',
        end: 'المكتمل فقط'
    }
};
