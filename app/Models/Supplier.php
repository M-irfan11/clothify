<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    public const TYPES = [
        'fabric' => 'Fabric',
        'accessories' => 'Accessories',
        'packaging' => 'Packaging',
        'other' => 'Other',
    ];

    public const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];

    protected $fillable = [
        'supplier_code',
        'company_name',
        'contact_person',
        'phone',
        'email',
        'address',
        'supplier_type',
        'payment_terms_days',
        'lead_time_days',
        'rating',
        'status',
    ];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'payment_terms_days' => 'integer',
            'lead_time_days' => 'integer',
            'rating' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function getSupplierTypeLabelAttribute(): string
    {
        return self::TYPES[$this->supplier_type] ?? $this->supplier_type;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
