<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    public const CATEGORIES = [
        'fabric' => 'Fabric',
        'thread' => 'Thread',
        'label' => 'Label',
        'packaging' => 'Packaging',
        'dye' => 'Dye',
        'other' => 'Other',
    ];

    public const UNITS = [
        'kg' => 'Kilogram (kg)',
        'meter' => 'Meter',
        'pcs' => 'Pieces',
        'cone' => 'Cone',
    ];

    public const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];

    protected $fillable = [
        'supplier_id',
        'material_code',
        'material_name',
        'sales_order_number',
        'category',
        'unit',
        'unit_cost',
        'reorder_level',
        'safety_stock',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'unit_cost' => 'decimal:2',
            'reorder_level' => 'decimal:2',
            'safety_stock' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function productionOrderMaterials(): HasMany
    {
        return $this->hasMany(ProductionOrderMaterial::class);
    }

    public function inventoryStocks(): HasMany
    {
        return $this->hasMany(InventoryStock::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }

    public function getUnitLabelAttribute(): string
    {
        return self::UNITS[$this->unit] ?? $this->unit;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
