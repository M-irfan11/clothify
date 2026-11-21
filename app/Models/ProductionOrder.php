<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionOrder extends Model
{
    public const STATUSES = [
        'planned' => 'Planned',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    protected $fillable = [
        'production_no',
        'product_variant_id',
        'source_warehouse_id',
        'planned_qty',
        'produced_qty',
        'wastage_qty',
        'start_date',
        'due_date',
        'completed_date',
        'status',
        'created_by',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'planned_qty' => 'integer',
            'produced_qty' => 'integer',
            'wastage_qty' => 'integer',
            'start_date' => 'date',
            'due_date' => 'date',
            'completed_date' => 'date',
        ];
    }

    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function sourceWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'source_warehouse_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public static function generateProductionNo(): string
    {
        $prefix = 'PRD-' . now()->format('Ym') . '-';

        $last = static::where('production_no', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('production_no');

        return $prefix . str_pad(($last ? (int) substr($last, -4) : 0) + 1, 4, '0', STR_PAD_LEFT);
    }
}