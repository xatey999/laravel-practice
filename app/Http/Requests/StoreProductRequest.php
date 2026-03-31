<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'string', Rule::in(ProductStatus::values())],
        ];

        if ($this->user()?->role->value === UserRoleEnum::ADMIN->value) {
            $rules['supplier_id'] = [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', UserRoleEnum::SUPPLIER->value),
            ];
        }

        return $rules;
    }
}
