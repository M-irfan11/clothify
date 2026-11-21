<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'material_id',
        'ordered_qty',
        'received_qty',
        'accepted_qty',
        'rejected_qty',
        'unit_price',
        'line_total',
    ];

    protected $casts = [
        'ordered_qty' => 'decimal:3',
        'received_qty' => 'decimal:3',
        'accepted_qty' => 'decimal:3',
        'rejected_qty' => 'decimal:3',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        // line_total = ordered_qty × unit_price (অটো)
        static::saving(function (self $item) {
            $item->line_total = round($item->ordered_qty * $item->unit_price, 2);
        });
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    // এখনো কতটা আসেনি
    public function getPendingQtyAttribute(): string
    {
        return bcsub((string) $this->ordered_qty, (string) $this->received_qty, 3);
    }
}
