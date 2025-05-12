<?php

namespace App\Http\Requests\Api\V1\Auth;

use App\Dto\Api\Auth\PersonalAccessTokenDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserAccessTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'string', 'max:191'],
            'password' => ['required', 'string', Password::defaults()],
            'device_name' => ['required', 'string', 'max:191'],
        ];
    }

    public function getDto(): PersonalAccessTokenDto
    {
        return new PersonalAccessTokenDto(...$this->validated());
    }
}
