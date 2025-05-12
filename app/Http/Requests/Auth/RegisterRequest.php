<?php

namespace App\Http\Requests\Auth;

use App\Dto\Auth\RegisterDto;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:'. User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function getDto(): RegisterDto
    {
        return new RegisterDto(...$this->validated());
    }
}
