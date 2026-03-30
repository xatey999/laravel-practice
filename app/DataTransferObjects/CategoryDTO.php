<?php

namespace App\DataTransferObjects;

class CategoryDTO
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?int $parent_id = null,
        public ?string $slug = null,
        public ?int $id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
            parent_id: $data['parent_id'] ?? null,
            slug: $data['slug'] ?? null,
            id: $data['id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'parent_id' => $this->parent_id,
            'slug' => $this->slug,
        ];
    }
}
