<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleOrderItem extends Model
{
    protected $fillable = [
        'sales_order_id',
        'product_variant_id',
        'quantity',
        'reserved_qty',
        'shipped_qty',
        'unit_price',
        'discount_percent',
        'line_total',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'reserved_qty' => 'integer',
        'shipped_qty' => 'integer',
        'unit_price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function salesOrder(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
