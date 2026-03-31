<?php

namespace App\DataTransferObjects;

class ProductDTO
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public float $price = 0,
        public int $stock_quantity = 0,
        public int $category_id = 0,
        public int $supplier_id = 0,
        public string $status = 'active',
        public ?string $slug = null,
        public ?int $id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
            price: (float) ($data['price'] ?? 0),
            stock_quantity: (int) ($data['stock_quantity'] ?? $data['stock'] ?? 0),
            category_id: (int) ($data['category_id'] ?? 0),
            supplier_id: (int) ($data['supplier_id'] ?? 0),
            status: $data['status'] ?? 'active',
            slug: $data['slug'] ?? null,
            id: $data['id'] ?? null,
        );
    }

    public function toArray(): array
    {
        $attributes = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock_quantity,
            'category_id' => $this->category_id,
            'supplier_id' => $this->supplier_id,
            'status' => $this->status,
        ];

        if ($this->slug !== null) {
            $attributes['slug'] = $this->slug;
        }

        return $attributes;
    }
}
