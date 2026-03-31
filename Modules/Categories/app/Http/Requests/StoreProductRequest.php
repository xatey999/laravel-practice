<?php

namespace Modules\Categories\Http\Requests;

use App\Enums\ProductStatus;
use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Categories\Models\Product;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'status' => ['required', 'string', Rule::in(ProductStatus::values())],
            'images' => ['nullable', 'array', 'max:8'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => ['integer'],
        ];

        if ($this->user()?->role->value === UserRoleEnum::ADMIN->value) {
            $rules['supplier_id'] = [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', UserRoleEnum::SUPPLIER->value),
            ];
        }

        $product = $this->route('product');
        $productId = $product instanceof Product ? $product->id : null;
        if ($productId !== null) {
            $rules['remove_image_ids.*'][] = Rule::exists('product_images', 'id')->where('product_id', $productId);
        }

        return $rules;
    }
}
