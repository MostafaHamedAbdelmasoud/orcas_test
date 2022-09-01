<?php


namespace App\Domain\User\Http\Requests\Auth;

use App\Domain\User\Entities\DeviceToken;
use App\Domain\User\Http\Rules\DeviceInfoRequiredRule;
use App\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;


class  UserLoginFormRequest extends FormRequest
{
    /**
     * Determine if the User is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email'             => ['required','email'],
            'password'          => ['required'],
        ];
        return $rules;
    }
}
