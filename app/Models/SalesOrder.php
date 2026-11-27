<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesOrder extends Model
{
    protected $fillable = [
        'order_no',
        'buyer_po_no',
        'customer_id',
        'warehouse_id',
        'order_date',
        'required_date',
        'subtotal',
        'discount_amount',
        'shipping_cost',
        'total_amount',
        'paid_amount',
        'payment_status',
        'status',
        'shipping_address',
        'created_by',
        'remarks',
    ];

    protected $casts = [
        'order_date' => 'date',
        'required_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public const STATUSES = [
        'pending', 'confirmed', 'packed',
        'partially_shipped', 'shipped', 'delivered', 'cancelled',
    ];

    public const PAYMENT_STATUSES = ['unpaid', 'partial', 'paid'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
