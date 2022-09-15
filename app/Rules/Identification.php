<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Identification implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return get_identity_card_number_validity($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '请输入合法的身份证号码';
    }
}
