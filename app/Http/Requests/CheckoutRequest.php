<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => ['required', 'array'],
            'items.*.quantity' => ['required', 'min:0', 'integer'],
            'items.*.options' => ['array', 'nullable'],
            'items.*.options.*.id' => ['required', 'exists:menu_item_options,id'],
            'items.*.options.*.value' => ['required', 'array'],
            'items.*.options.*.value.*' => ['required', Rule::exists('menu_item_option_values', 'id')],
            'items.*.menu_item_id' => ['required', 'exists:menu_items,id'],
        ];
    }
}
