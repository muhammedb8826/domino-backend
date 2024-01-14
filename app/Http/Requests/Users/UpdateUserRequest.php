<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'phone' => ['required',Rule::unique('users')->ignore($this->user->id)],
            'email' => ['required','email:rfc,dns', Rule::unique('users')->ignore($this->user)],
            'joined_date' => ['required', 'date'],
            'photo'=>['nullable']
        ];
    }

}
