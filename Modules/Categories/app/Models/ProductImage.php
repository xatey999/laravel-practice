<?php

namespace Modules\Categories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    use HasFactory;

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
