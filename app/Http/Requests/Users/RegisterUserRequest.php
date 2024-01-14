<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'last_name' => ['required'],
            'gender' => ['nullable', 'in:male,female'],
            'phone' => ['required', 'unique:users,phone'],
            'email' => ['email:rfc,dns,unique:users,email'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'joined_date' => ['required', 'date'],
            'photo'=>['nullable']
        ];
    }
    protected function passedValidation()
    {
        $this['password'] = Hash::make($this->password);
        return $this;
    }
}
