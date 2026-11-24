<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryStock extends Model
{
    public $timestamps = false; // updated_at DB নিজে handle করছে

    protected $fillable = [
        'warehouse_id',
        'material_id',
        'product_variant_id',
        'quantity',
        'reserved_qty',
    ];

    protected function casts(): array
    {
        return [
            'quantity'     => 'decimal:3',
            'reserved_qty' => 'decimal:3',
        ];
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    // available = quantity - reserved
    public function getAvailableQtyAttribute(): string
    {
        return bcsub((string) $this->quantity, (string) $this->reserved_qty, 3);
    }
}