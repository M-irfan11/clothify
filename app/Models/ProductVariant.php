<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'sku',
        'size',
        'color',
        'cost_price',
        'selling_price',
        'reorder_level',
        'status',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'reorder_level' => 'integer',
    ];

    /**
     * Route model binding-এ {product_variant} এর সাথে মেলানোর জন্য।
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * এই variant কোন product এর।
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * শুধু active variant আনার scope।
     * ব্যবহার: product_variants::active()->get();
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }
}
