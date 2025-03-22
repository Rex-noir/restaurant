<?php

namespace App\Http\Requests;

use App\enums\GenderEnums;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'profile' => ['required', 'sometimes', 'array'],
            'profile.gender' => ['required', 'sometimes', 'string', Rule::enum(GenderEnums::class)],
            'profile.phone' => ['required', 'sometimes', 'string', 'max:255'],
            'profile.date_of_birth' => ['nullable', 'sometimes', 'date'],
            'profile.profile_image' => ['nullable', 'sometimes', 'file', 'max:2048'],
            'new_password' => ['string', 'nullable', 'sometimes', 'min:8', 'confirmed'],
            'current_password' => ['sometimes', 'current_password', 'required_with:new_password', 'string', 'min:8', 'nullable'],
        ];
    }

}
