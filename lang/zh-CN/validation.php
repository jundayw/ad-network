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

    'accepted' => ':attribute 必须接受',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => ':attribute 必须是一个合法的 URL',
    'after' => ':attribute 必须是 :date 之后的一个日期',
    'after_or_equal' => ':attribute 必须是 :date 之后或相同的一个日期',
    'alpha' => ':attribute 只能包含字母',
    'alpha_dash' => ':attribute 只能包含字母、数字、中划线或下划线',
    'alpha_num' => ':attribute 只能包含字母和数字',
    'array' => ':attribute 必须是一个数组',
    'before' => ':attribute 必须是 :date 之前的一个日期',
    'before_or_equal' => ':attribute 必须是 :date 之前或相同的一个日期',
    'between' => [
        'array' => ':attribute 必须在 :min 到 :max 项之间',
        'file' => ':attribute 必须在 :min 到 :max KB 之间',
        'numeric' => ':attribute 必须在 :min 到 :max 之间',
        'string' => ':attribute 必须在 :min 到 :max 个字符之间',
    ],
    'boolean' => ':attribute 字符必须是 true 或 false',
    'confirmed' => ':attribute 二次确认不匹配',
    'current_password' => 'The password is incorrect.',
    'date' => ':attribute 必须是一个合法的日期',
    'date_equals' => ':attribute 必须等于 :date',
    'date_format' => ':attribute 与给定的格式 :format 不符合',
    'declined' => 'The :attribute must be declined.',
    'declined_if' => 'The :attribute must be declined when :other is :value.',
    'different' => ':attribute 必须不同于 :other',
    'digits' => ':attribute 必须是 :digits 位',
    'digits_between' => ':attribute 必须在 :min 和 :max 位之间',
    'dimensions' => ':attribute 具有无效的图片尺寸',
    'distinct' => ':attribute 具有重复值',
    'email' => ':attribute 必须是一个合法的电子邮件地址',
    'ends_with' => 'The :attribute must end with one of the following: :values.',
    'enum' => 'The selected :attribute is invalid.',
    'exists' => ':attribute 无效',
    'file' => ':attribute 必须是一个文件',
    'filled' => ':attribute 必填',
    'gt' => [
        'array' => ':attribute 至少有 :value 项',
        'file' => ':attribute 大小至少为 :value KB',
        'numeric' => ':attribute 需大于 :value',
        'string' => ':attribute 的最小长度为 :value 字符',
    ],
    'gte' => [
        'array' => ':attribute 至少有 :value 项',
        'file' => ':attribute 大小至少为 :value KB',
        'numeric' => ':attribute 需大于等于 :value',
        'string' => ':attribute 的最小长度为 :value 字符',
    ],
    'image' => ':attribute 必须是 jpeg, png, bmp 或者 gif 格式的图片',
    'in' => ':attribute 是无效的',
    'in_array' => ':attribute 不存在于 :other',
    'integer' => ':attribute 必须是个整数',
    'ip' => ':attribute 必须是一个合法的 IP 地址',
    'ipv4' => ':attribute 必须是 IPv4 地址.',
    'ipv6' => ':attribute 必须是 IPv6 地址',
    'json' => ':attribute 必须是一个合法的 JSON 字符串',
    'lt' => [
        'array' => ':attribute 至少有 :value 项',
        'file' => ':attribute 大小至少为 :value KB',
        'numeric' => ':attribute 需小于 :value',
        'string' => ':attribute 的最小长度为 :value 字符',
    ],
    'lte' => [
        'array' => ':attribute 至少有 :value 项',
        'file' => ':attribute 大小至少为 :value KB',
        'numeric' => ':attribute 需小于等于 :value',
        'string' => ':attribute 的最小长度为 :value 字符',
    ],
    'mac_address' => 'The :attribute must be a valid MAC address.',
    'max' => [
        'array' => ':attribute 至少有 :max 项',
        'file' => ':attribute 大小至少为 :max KB',
        'numeric' => ':attribute 不大于 :max',
        'string' => ':attribute 的最小长度为 :max 字符',
    ],
    'mimes' => ':attribute 的文件类型必须是 :values',
    'mimetypes' => ':attribute 的文件类型和 :values 不一致',
    'min' => [
        'array' => ':attribute 至少有 :min 项',
        'file' => ':attribute 大小至少为 :min KB',
        'numeric' => ':attribute 不小于 :min',
        'string' => ':attribute 的最小长度为 :min 字符',
    ],
    'multiple_of' => 'The :attribute must be a multiple of :value.',
    'not_in' => ':attribute 是无效的',
    'not_regex' => ':attribute 格式无效',
    'numeric' => ':attribute 必须是数字',
    'password' => [
        'letters' => 'The :attribute must contain at least one letter.',
        'mixed' => 'The :attribute must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute must contain at least one number.',
        'symbols' => 'The :attribute must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => ':attribute 必须存在',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => ':attribute 格式是无效的',
    'required' => ':attribute 必填',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => ':attribute 是必须的当 :other 是 :value',
    'required_unless' => ':attribute 是必须的，除非 :other 是在 :values 中',
    'required_with' => ':attribute 是必须的当 :values 是存在的',
    'required_with_all' => ':attribute 是必须的当 :values 是存在的',
    'required_without' => ':attribute 是必须的当 :values 是不存在的',
    'required_without_all' => ':attribute 是必须的当 没有一个 :values 是存在的',
    'same' => ':attribute 和 :other 不一致',
    'size' => [
        'array' => ':attribute 必须包括 :size 项',
        'file' => ':attribute 必须是 :size KB',
        'numeric' => ':attribute 必须是 :size 位',
        'string' => ':attribute 必须是 :size 个字符',
    ],
    'starts_with' => ':attribute 必须以 :values 开头',
    'string' => ':attribute 必须是一个字符串',
    'timezone' => ':attribute 必须是个有效的时区',
    'unique' => ':attribute 已存在',
    'uploaded' => 'The :attribute failed to upload.',
    'url' => ':attribute 无效的格式',
    'uuid' => ':attribute 格式有误',

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
