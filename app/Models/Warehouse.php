<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    public const TYPES = [
        'raw_material' => 'Raw Material',
        'finished_goods' => 'Finished Goods',
        'both' => 'Both',
    ];

    public const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];

    protected $fillable = [
        'warehouse_name',
        'warehouse_code',
        'warehouse_type',
        'address',
        'phone',
        'status',
    ];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function getWarehouseTypeLabelAttribute(): string
    {
        return self::TYPES[$this->warehouse_type] ?? $this->warehouse_type;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
