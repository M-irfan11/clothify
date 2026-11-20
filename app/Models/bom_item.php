<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class bom_item extends Model
{
    protected $table = 'bom_items';

    protected $fillable = [
        'product_variant_id',
        'material_id',
        'quantity_per_unit',
        'wastage_percent',
    ];

    protected $casts = [
        'quantity_per_unit' => 'decimal:4',
        'wastage_percent' => 'decimal:2',
    ];

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
