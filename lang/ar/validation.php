<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'not_allowed_to_delete' => 'غير مسموح لك بالحذف',
    'same_parent' => 'لا يمكن حذف الصنف الاولى',
    'delete_admin' => 'لا يمكن حذف المدير الاخير',
    'feedback' => 'هذا التقرير لا يمكن تعديله',
    'cannot_move_to_this_status'=> 'لا يمكن الانتقال لهذه الحالة',
    'cannot_delete' => 'لا يمكن الحذف  ',
    'not_exist' => 'غير موجود',
    'email_required' => 'برجاء إدخال البريد الإلكترونى',
    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute is not a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',
    'alpha' => 'The :attribute must only contain letters.',
    'alpha_dash' => 'The :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute must only contain letters and numbers.',
    'array' => 'The :attribute must be an array.',
    'ascii' => 'The :attribute must only contain single-byte alphanumeric characters and symbols.',
    'before' => 'The :attribute must be a date before :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'array' => 'The :attribute must have between :min and :max items.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'numeric' => 'The :attribute must be between :min and :max.',
        'string' => 'The :attribute must be between :min and :max characters.',
    ],
    'boolean' => 'The :attribute field must be true or false.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'current_password' => 'The password is incorrect.',
    'date' => 'The :attribute is not a valid date.',
    'date_equals' => 'The :attribute must be a date equal to :date.',
    'date_format' => 'The :attribute does not match the format :format.',
    'decimal' => 'The :attribute must have :decimal decimal places.',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => 'The :attribute and :other must be different.',
    'digits' => 'The :attribute must be :digits digits.',
    'digits_between' => 'The :attribute must be between :min and :max digits.',
    'dimensions' => 'The :attribute has invalid image dimensions.',
    'distinct' => 'The :attribute field has a duplicate value.',
    'doesnt_end_with' => 'The :attribute may not end with one of the following: :values.',
    'doesnt_start_with' => 'The :attribute may not start with one of the following: :values.',
   // 'email' => 'The :attribute must be a valid email address.',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => 'The selected :attribute is invalid.',
    'file' => 'The :attribute must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'array' => 'The :attribute must have more than :value items.',
        'file' => 'The :attribute must be greater than :value kilobytes.',
        'numeric' => 'The :attribute must be greater than :value.',
        'string' => 'The :attribute must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute must have :value items or more.',
        'file' => 'The :attribute must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute must be greater than or equal to :value.',
        'string' => 'The :attribute must be greater than or equal to :value characters.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => 'The :attribute must be a valid IPv4 address.',
    'ipv6' => 'The :attribute must be a valid IPv6 address.',
    'json' => 'The :attribute must be a valid JSON string.',
    'lowercase' => 'The :attribute must be lowercase.',
    'lt' => [
        'array' => 'The :attribute must have less than :value items.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'numeric' => 'The :attribute must be less than :value.',
        'string' => 'The :attribute must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute must not have more than :value items.',
        'file' => 'The :attribute must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute must be less than or equal to :value.',
        'string' => 'The :attribute must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'array' => 'The :attribute must not have more than :max items.',
        'file' => 'The :attribute must not be greater than :max kilobytes.',
        'numeric' => 'The :attribute must not be greater than :max.',
        'string' => 'The :attribute must not be greater than :max characters.',
    ],
    'max_digits' => 'The :attribute must not have more than :max digits.',
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'array' => 'The :attribute must have at least :min items.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'numeric' => 'The :attribute must be at least :min.',
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'min_digits' => 'The :attribute must have at least :min digits.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute format is invalid.',
    'numeric' => 'The :attribute must be a number.',
    // 'password' => [
    //     'letters' => 'The :attribute must contain at least one letter.',
    //     'mixed' => 'The :attribute must contain at least one uppercase and one lowercase letter.',
    //     'numbers' => 'The :attribute must contain at least one number.',
    //     'symbols' => 'The :attribute must contain at least one symbol.',
    //     'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    // ],
    'present' => 'The :attribute field must be present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => ':attribute برجاء إدخال ' ,
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'array' => 'The :attribute must contain :size items.',
        'file' => 'The :attribute must be :size kilobytes.',
        'numeric' => 'The :attribute must be :size.',
        'string' => 'The :attribute must be :size characters.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values.',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'The :attribute must be uppercase.',
    'url' => 'The :attribute must be a valid URL.',
    'ulid' => 'The :attribute must be a valid ULID.',
    'uuid' => 'The :attribute must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],
    'title_ar'  =>[
        'required'  =>  'العنوان العربي مطلوب'
    ],
    'title_en'  =>[
        'required'  =>  'العنوان الانجليزي مطلوب'
    ],
    'description_ar'  =>[
        'required'  =>  'الوصف العربي مطلوب'
    ],
    'description_en'  =>[
        'required'  =>  'الوصف الانجليزي مطلوب'
    ],
    'email' =>[
        'required'  =>  'البريد الالكتروني مطلوب',
        'email'  =>  'البريد الالكتروني غير صحيح',
        'exists'  =>  'البريد الالكتروني غير موجود',
    ],
    'password'=>[
        'required'  =>  'كلمة المرور مطلوبة',
        'min'  =>  'كلمة المرور يجب ان تكون اكثر من 6 احرف',
    ],
    'token' => [
        'required'  =>  'كود التحقق مطلوب',
    ],
    'name' => [
        'required'  =>  'الاسم  مطلوب',
    ],
    'name_ar' => [
        'required'  =>  'الاسم العربي مطلوب',
    ],
    'name_en' => [
        'required'  =>  'الاسم الانجليزي مطلوب',
    ],
    'id' => [
        'required'  =>  ' id مطلوب',
        'exists'  =>  ' id غير موجود',
    ],
    'have_sub_categories' => [
        'required'  =>  'حدد يوجد الفئة الفرعية ام لا',
    ],
    'img_path' => [
        'required'  =>  'الصورة مطلوبة',
    ],
    'parent_id' => [
        'exists'  =>  ' id غير موجود',
    ],
    'active' => [
        'required'  =>  'حدد الحالة  مفعل ام لا',
        'in'    => 'حدد بين القيم (0) و (1)'
    ],
    'phone' => [
        'required'  =>  'رقم الهاتف مطلوب'
    ],
    'age' => [
        'required'  =>  'العمر مطلوب'
    ],
    'address' => [
        'required'  =>  'العنوان مطلوب'
    ],
    'gender' => [
        'required'  =>  'الجنس مطلوب'
    ],
    'feedback_message' => [
        'required'  =>  'التعليق مطلوب'
    ],
    'value' => [
        'required'  =>  'القيمة مطلوبة',
        'numeric' => 'القيمة يجب ان تكون رقم',
        'between' => 'القيمة يجب ان تكون بين 0 و 10',
    ],
    'value_type' => [
        'required'  =>  'النوع مطلوب',
    ],
    'orders_per_hour'   => [
        'numeric' => 'القيمة يجب ان يكون رقم',
    ],
    'after_hours'   => [
        'required'  =>  'الساعات مطلوبة',
    ],
    'added_value_type'   => [
        'required'  =>  'النوع مطلوب',
    ],
    'added_value'   => [
        'required'  =>  'القيمة مطلوبة',
    ],
    'capacity_per_hour'   => [
        'required'  =>  'الساعات مطلوبة',
        'numeric' => 'القيمة يجب ان يكون رقم',
    ],
    'longitude'   => [
        'required'  =>  'حقل الطول مطلوب',
        'numeric' => 'حقل الطول يجب ان يكون رقم',
    ],
    'latitude'   => [
        'required'  =>  'حقل العرض مطلوب',
        'numeric' => 'حقل العرض يجب ان يكون رقم',
    ],
    'delivery_type'   => [
        'required'  =>  'طريقة التوصيل مطلوبة',
    ],
    'options' => [
        'name'  => [
            'required'  =>  'الاسم مطلوب',
        ],
        'price'  => [
            'required'  =>  'السعر مطلوب',
            'numeric' => 'السعر يجب ان يكون رقم',
        ],
    ],
    'question_ar' => [
        'required'  =>  'السؤال العربي مطلوب',
    ],
    'question_en' => [
        'required'  =>  'السؤال الانجليزي مطلوب',
    ],
    'answer_ar' => [
        'required'  =>  'الاجابة العربية مطلوبة',
    ],
    'answer_en' => [
        'required'  =>  'الاجابة الانجليزية مطلوبة',
    ],
    'from' => [
        'required'  =>  'بداية المدة من مطلوب',
    ],
    'to' => [
        'required'  =>  'نهاية المدة مطلوب',
    ],
    'content_ar' => [
        'required'  =>  'المحتوى العربي مطلوب',
    ],
    'content_en' => [
        'required'  =>  'المحتوى الانجليزي مطلوب',
    ],
    'button_text_ar' => [
        'required'  =>  'العنوان الزر العربي مطلوب',
    ],
    'button_text_en' => [
        'required'  =>  'العنوان الزر الانجليزي مطلوب',
    ],
    'navbar_footer' => [
        'whatsapp_number' => [
            'required'  =>  'رقم الواتس مطلوب',
        ],
        'phone_number' => [
            'required'  =>  'رقم الهاتف مطلوب',
        ],
        'facebook_link' => [
            'required'  =>  'راقم الفيسبوك مطلوب',
        ],
        'instagram_link' => [
            'required'  =>  'رابط الانستغرام مطلوب',
        ],
        'twitter_link' => [
            'required'  =>  'رابط التويتر مطلوب',
        ],
        'app_store_link' => [
            'required'  =>  'رابط التطبيق مطلوب',
        ],
        'google_play_link' => [
            'required'  =>  'رابط التطبيق مطلوب',
        ]
    ],
    'text' => [
        'required'  =>  'النص مطلوب',
    ],
    'status' => [
        'required'  =>  'حدد الحالة المطلوبة',
    ],
    'price_unit_ar' => [
        'required'  =>  'الوحدة السعرية العربية مطلوبة',
    ],
    'price_unit_en' => [
        'required'  =>  'الوحدة السعرية الانجليزية مطلوبة',
    ],
    'code'  => [
        'required'  =>  'الكود مطلوب',
    ],
    'type'  => [
        'required'  =>  'النوع مطلوب',
    ],
    'first_order_cash_back_value' => [
        'required'  =>  'قيمة النقود المستردة لاول طلب مطلوبة',
    ],
    'first_order_cash_back_value_type' => [
        'required'  =>  'نوع نسبة النقود المستردة لاول طلب مطلوب',
    ],
    'invitation_code_owner_cash_value' => [
        'required'  =>  'كود دعوة من المالك مطلوب',
    ],
    'invitation_code_owner_cash_value_type' => [
        'required'  =>  'نوع كود دعوة من المالك مطلوب',
    ],
    'invitation_code_user_cash_value' => [
        'required'  =>  'كود دعوة من المستخدم مطلوب',
    ],
    'invitation_code_user_cash_value_type' => [
        'required'  =>  'نوع كود دعوة من المستخدم مطلوب',
    ],
    'link' => [
        'required'  =>  'الرابط مطلوب',
    ],
    'percentage' => [
        'required'  =>  'النسبة مطلوبة',
    ],
    'capacity' => [
        'required'  =>  'السعة مطلوبة',
    ],

];
