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

    'accepted' => ':attribute kabul edilmelidir.',
    'active_url' => ':attribute geçerli bir URL değil.',
    'after' => ':attribute :date tarihinden daha ileri bir tarih olmalıdır.',
    'after_or_equal' => ':attribute en erken :date tarihi olabilir.',
    'alpha' => ':attribute sadece harf içermelidir.',
    'alpha_dash' => ':attribute karakter, rakam, tire veya alt tire içerebilir.',
    'alpha_num' => ':attribute sadece harf ve rakam içerebilir.',
    'array' => ':attribute bir dizi olmalıdır.',
    'before' => ':attribute :date tarihinden daha önce bir tarih olmalıdır.',
    'before_or_equal' => ':attribute en geç :date tarihi olabilir.',
    'between' => [
        'numeric' => ':attribute en az :min, en fazla :max olabilir.',
        'file' => ':attribute en az :min, en fazla :max kilobytes olabilir.',
        'string' => ':attribute en az :min, en fazla :max karakter olabilir.',
        'array' => 'The :attribute en az :min, en fazla :max eleman içerebilir..',
    ],
    'boolean' => ':attribute yalnızca doğru veya yanlış olabilir..',
    'confirmed' => 'İki :attribute eşleşmiyor.',
    'date' => ':attribute geçerli bir tarih değil.',
    'date_equals' => ':attribute :date tarihi olmalıdır.',
    'date_format' => ':attribute :format formatı ile uyuşmuyor.',
    'different' => ':attribute ile :other farklı olmalıdır.',
    'digits' => 'The :attribute :digits hane olmalıdır.',
    'digits_between' => ':attribute en az :min, en fazla :max hane olabilir.',
    'dimensions' => ':attribute desteklenmeyen resim boyutlarına sahip.',
    'distinct' => ':attribute alanı yinelenen bir değere sahiptir.',
    'email' => ':attribute geçerli bir e-posta adresi olmalıdır.',
    'ends_with' => ':attribute bunlardan biri ile bitmelidir: :values',
    'exists' => 'Seçilen :attribute alanı geçersiz.',
    'file' => ':attribute dosya olmalıdır.',
    'filled' => ':attribute boş bırakılamaz.',
    'gt' => [
        'numeric' => ':attribute :value değerinden büyük olmalıdır.',
        'file' => ':attribute :value kilobytes boyutundan büyük olmalıdır.',
        'string' => ':attribute :value karakterden daha fazla karakterden oluşmalıdır.',
        'array' => ':attribute :value elemandan fazlasını içermelidir.',
    ],
    'gte' => [
        'numeric' => ':attribute :value olmalıdır.',
        'file' => ':attribute en az :value kilobytes olmalıdır.',
        'string' => ':attribute en az :value karakter içermelidir.',
        'array' => ':attribute en az :value eleman içermelidir.',
    ],
    'image' => ':attribute bir resim olmalıdır.',
    'in' => 'Seçilen :attribute geçersiz.',
    'in_array' => ':attribute :other dizisinde mevcut değil.',
    'integer' => ':attribute sayısal bir değer olmalıdır.',
    'ip' => ':attribute geçerli bir IP adresi olmalıdır.',
    'ipv4' => ':attribute geçerli bir IPv4 adresi olmalıdır.',
    'ipv6' => ':attribute geçerli bir IPv6 adresi olmalıdır.',
    'json' => ':attribute geçerli bir JSON metni olmalıdır.',
    'lt' => [
        'numeric' => 'The :attribute must be less than :value.',
        'file' => 'The :attribute must be less than :value kilobytes.',
        'string' => 'The :attribute must be less than :value characters.',
        'array' => 'The :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'The :attribute must be less than or equal :value.',
        'file' => 'The :attribute must be less than or equal :value kilobytes.',
        'string' => 'The :attribute must be less than or equal :value characters.',
        'array' => 'The :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
    ],
    'mimes' => 'The :attribute must be a file of type: :values.',
    'mimetypes' => 'The :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'file' => 'The :attribute must be at least :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => 'Seçilen :attribute geçersiz.',
    'not_regex' => ':attribute formatı geçersiz.',
    'numeric' => ':attribute sayı olmalıdır.',
    'password' => 'Şifre yanlış.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'The :attribute format is invalid.',
    'required' => ':attribute alanı boş bırakılamaz.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => 'The :attribute must start with one of the following: :values',
    'string' => 'The :attribute must be a string.',
    'timezone' => 'The :attribute must be a valid zone.',
    'unique' => 'Bu :attribute daha önce kullanılmış.',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => 'The :attribute format is invalid.',
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

];
