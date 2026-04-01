<?php

namespace Modules\Categories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Categories\Database\Factories\ProductImageFactory;

class ProductImage extends Model
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return ProductImageFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];

    /**
     * Get the product that owns the product image.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
