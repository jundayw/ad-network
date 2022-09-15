<?php

namespace App\Http\Requests;

use App\Exceptions\RenderErrorResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as ValidatesFormRequest;
use Illuminate\Validation\UnauthorizedException;

abstract class FormRequest extends ValidatesFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        //
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\UnauthorizedException
     */
    protected function failedAuthorization(): void
    {
        throw new UnauthorizedException();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        $error  = $validator->errors()->first();
        $errors = $validator->errors()->messages();

        throw new RenderErrorResponseException(error: $error, errors: $errors);
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        //
    }

}
