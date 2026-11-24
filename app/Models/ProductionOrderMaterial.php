<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionOrderMaterial extends Model
{
    protected $fillable = [
        'production_order_id',
        'material_id',
        'planned_qty',
        'issued_qty',
        'used_qty',
        'return_qty',
        'wastage_qty',
    ];

    protected function casts(): array
    {
        return [
            'planned_qty' => 'decimal:3',
            'issued_qty' => 'decimal:3',
            'used_qty' => 'decimal:3',
            'return_qty' => 'decimal:3',
            'wastage_qty' => 'decimal:3',
        ];
    }

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
