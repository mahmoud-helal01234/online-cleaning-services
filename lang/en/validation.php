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
    'not_allowed_to_delete' => 'you are not authorize to delete',
    'same_parent' => 'can not delete same parent',
    'delete_admin' => 'can not delete last Admin',
    'feedback' => 'its not your feedback',
    'cannot_move_to_this_status'=> 'Cannot move to this status',
    'cannot_delete' => 'can not delete',
    'not_exist' => 'not exists',
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
    //'email' => 'The :attribute must be a valid email address.',
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
    'required' => 'The :attribute field is required.',
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
    'failed'    => [
        'failed'  =>  'Email or password is incorrect',
    ],
    'title_ar'  =>[
        'required'  =>  'Arabic Title is required'
    ],
    'title_en'  =>[
        'required'  =>  'English Title is required'
    ],
    'description_ar'  =>[
        'required'  =>  'Arabic Description is required'
    ],
    'description_en'  =>[
        'required'  =>  'English Description is required'
    ],
    'email' =>[
        'required'  =>  'Email is required',
        'email'  =>  'Email is invalid',
        'exists'  =>  'Email is already exist',
    ],
    'password'=>[
        'required'  =>  'Password is required',
        'min'  =>  'Password must be at least 6 characters',
    ],
    'token' => [
        'required'  =>  'Token is required',
    ],
    'id' => [
        'required'  =>  ' id is required',
        'exists'  =>  ' id  does not exist',
    ],
    'name' => [
        'required'  =>  ' Name is required',
    ],
    'name_ar' => [
        'required'  =>  'Arabic Name is required',
    ],
    'name_en' => [
        'required'  =>  'English Name is required',
    ],
    'have_sub_categories' => [
        'required'  =>  'choose have sub category or not',
    ],
    'img_path' => [
        'required'  =>  'Image is required',
    ],
    'parent_id' => [
        'exists'  =>  ' id does not exist',
    ],
    'active'    => [
        'required'  =>  'active is required',
        'in'    =>  'choose value between 0 and 1',
    ],
    'phone' => [
        'required'  =>  'phone is required',
    ],
    'age' => [
        'required'  =>  'age is required',
    ],
    'address' => [
        'required'  =>  'address is required',
    ],
    'gender' => [
        'required'  =>  'gender is required',
    ],
    'feedback_message' => [
        'required'  =>  'feedback message is required',
    ],
    'value' => [
        'required'  =>  'value is required',
        'numeric' => 'value must be a number',
        'between' => 'value must be between 0 and 10',
    ],
    'value_type' => [
        'required'  =>  'value type is required',
    ],
    'orders_per_hour'   => [
        'numeric' => 'orders per hour must be a number',
    ],
    'after_hours'   => [
        'required'  =>  'after hours is required',
    ],
    'added_value_type'   => [
        'required'  =>  'added value type is required',
    ],
    'added_value'   => [
        'required'  =>  'added value is required',
    ],
    'capacity_per_hour'   => [
        'required'  =>  'capacity per hour is required',
        'numeric' => 'capacity per hour must be a number',
    ],
    'longitude'   => [
        'required'  =>  'longitude is required',
        'numeric' => 'longitude must be a number',
    ],
    'latitude'   => [
        'required'  =>  'latitude is required',
        'numeric' => 'latitude must be a number',
    ],
    'delivery_type'   => [
        'required'  =>  'delivery type is required',
    ],
    'options' => [
        'name'  => [
            'required'  =>  'name is required',
        ],
        'price'  => [
            'required'  =>  'price is required',
            'numeric' => 'price must be a number',
        ],
        'quantity'  => [
            'required'  =>  'quantity is required',
            'numeric' => 'quantity must be a number',
        ],
    ],
    'question_ar' => [
        'required'  =>  'Arabic question is required',
    ],
    'question_en' => [
        'required'  =>  'English question is required',
    ],
    'answer_ar' => [
        'required'  =>  'Arabic answer is required',
    ],
    'answer_en' => [
        'required'  =>  'English answer is required',
    ],
    'from' => [
        'required'  =>  'From is required',
    ],
    'to' => [
        'required'  =>  'To is required',
    ],
    'content_ar' => [
        'required'  =>  'Arabic content is required',
    ],
    'content_en' => [
        'required'  =>  'English content is required',
    ],
    'button_text_ar' => [
        'required'  =>  'Arabic button text is required',
    ],
    'button_text_en' => [
        'required'  =>  'English button text is required',
    ],
    'discount_value_type' => [
        'required'  =>  'discount value type is required',
        'in'    =>  'choose value between constant and percentage',
    ],
    'tax_value_type' => [
        'required'  =>  'tax value type is required',
        'in'    =>  'choose value between constant and percentage',
    ],
    'navbar_footer' => [
        'whatsapp_number' => [
            'required'  =>  'Whatsapp number is required',
        ],
        'phone_number' => [
            'required'  =>  'Phone number is required',
        ],
        'facebook_link' => [
            'required'  =>  'Facebook link is required',
        ],
        'instagram_link' => [
            'required'  =>  'Instagram link is required',
        ],
        'twitter_link' => [
            'required'  =>  'Twitter link is required',
        ],
    ],
    'app_store_link' => [
        'required'  =>  'App store link is required',
    ],
    'google_play_link' => [
        'required'  =>  'Google play link is required',
    ],
    'text' => [
        'required'  =>  'Text is required',
    ],
    'status' => [
        'required'  =>  'Status is required',
    ],
    'price_unit_ar' => [
        'required'  =>  'Arabic price unit is required',
    ],
    'price_unit_en' => [
        'required'  =>  'English price unit is required',
    ],
    'code'  => [
        'required'  =>  'Code is required',
    ],
    'type'  => [
        'required'  =>  'Type is required',
    ],
    'first_order_cash_back_value' => [
        'required'  =>  'First order cash back value is required',
    ],
    'first_order_cash_back_value_type' => [
        'required'  =>  'First order cash back value type is required',
    ],
    'invitation_code_owner_cash_value' => [
        'required'  =>  'Invitation code owner cash value is required',
    ],
    'invitation_code_owner_cash_value_type' => [
        'required'  =>  'Invitation code owner cash value type is required',
    ],
    'invitation_code_user_cash_value' => [
        'required'  =>  'Invitation code user cash value is required',
    ],
    'invitation_code_user_cash_value_type' => [
        'required'  =>  'Invitation code user cash value type is required',
    ],
    'link' => [
        'required'  =>  'Link is required',
    ],
    'percentage' => [
        'required'  =>  'Precentage is required',
    ],
    'capacity' => [
        'required'  =>  'Capacity is required',
    ],
];
