<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class stock_movement extends Model
{
    public const MOVEMENT_TYPES = [
        'purchase_in' => 'Purchase In',
        'production_use' => 'Production Use',
        'production_out' => 'Production Output',
        'sale_out' => 'Sale Out',
        'transfer_in' => 'Transfer In',
        'transfer_out' => 'Transfer Out',
        'adjustment' => 'Adjustment',
        'return_in' => 'Return In',
        'reversal' => 'Reversal',
    ];

    public const POSITIVE_QUANTITY_TYPES = [
        'purchase_in',
        'production_out',
        'transfer_in',
        'return_in',
    ];

    public const NEGATIVE_QUANTITY_TYPES = [
        'production_use',
        'sale_out',
        'transfer_out',
    ];

    public const REFERENCE_TYPES = [
        'purchase_order' => 'Purchase Order',
        'production_order' => 'Production Order',
        'sales_order' => 'Sales Order',
        'shipment' => 'Shipment',
        'qc' => 'Quality Control',
    ];

    protected $table = 'stock_movements';

    protected $fillable = [
        'warehouse_id',
        'material_id',
        'product_variant_id',
        'movement_type',
        'quantity',
        'unit_cost',
        'reference_type',
        'reference_id',
        'movement_date',
        'created_by',
        'remarks',
    ];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:3',
            'unit_cost' => 'decimal:2',
            'movement_date' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function getMovementTypeLabelAttribute(): string
    {
        return self::MOVEMENT_TYPES[$this->movement_type] ?? $this->movement_type;
    }

    public function getReferenceTypeLabelAttribute(): ?string
    {
        if ($this->reference_type === null) {
            return null;
        }

        return self::REFERENCE_TYPES[$this->reference_type] ?? $this->reference_type;
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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
