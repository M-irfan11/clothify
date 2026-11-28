<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Customer extends Model
{
    //
    use HasFactory,SoftDeletes;

    public const TYPES = ['wholesale', 'retail', 'online', 'corporete', 'export'];

    public const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'blocked' => 'Blocked',
    ];

    protected $fillable = [
        'customer_code',
        'customer_name',
        'customer_type',
        'contact_person',
        'phone',
        'email',
        'address',
        'buyer_reference',
        'credit_limit',
        'status',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
