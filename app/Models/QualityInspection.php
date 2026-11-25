<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QualityInspection extends Model
{
    public const TYPES = [
        'incoming_material' => 'Incoming Material',
        'in_process'        => 'In Process',
        'final_product'     => 'Final Product',
    ];

    protected $fillable = [
        'inspection_no', 'inspection_type',
        'purchase_order_item_id', 'production_order_id',
        'material_id', 'product_variant_id',
        'inspected_qty', 'passed_qty', 'rejected_qty', 'rework_qty',
        'defect_details', 'remarks', 'inspected_by', 'inspection_date',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'inspected_qty'   => 'decimal:3',
        'passed_qty'      => 'decimal:3',
        'rejected_qty'    => 'decimal:3',
        'rework_qty'      => 'decimal:3',
    ];

    public function purchaseOrderItem(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrderItem::class);
    }

    public function productionOrder(): BelongsTo
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspected_by');
    }
}