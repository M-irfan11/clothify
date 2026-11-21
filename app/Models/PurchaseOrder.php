<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    public const STATUSES = [
        'draft' => 'Draft',
        'approved' => 'Approved',
        'sent' => 'Sent',
        'partial_received' => 'Partial Received',
        'received' => 'Received',
        'cancelled' => 'Cancelled',
    ];

    public const PAYMENT_STATUSES = [
        'unpaid' => 'Unpaid',
        'partial' => 'Partial',
        'paid' => 'Paid',
    ];

    protected $fillable = [
        'po_no', 'supplier_id', 'warehouse_id',
        'order_date', 'expected_date', 'received_date',
        'subtotal', 'tax_amount', 'total_amount', 'paid_amount',
        'payment_status', 'status',
        'approved_by', 'created_by', 'remarks',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_date' => 'date',
        'received_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return self::PAYMENT_STATUSES[$this->payment_status] ?? ucfirst($this->payment_status);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'received' => 'bg-gradient-success',
            'partial_received' => 'bg-gradient-info',
            'approved', 'sent' => 'bg-gradient-primary',
            'cancelled' => 'bg-gradient-danger',
            default => 'bg-gradient-secondary',
        };
    }

    public function getPaymentBadgeAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'bg-gradient-success',
            'partial' => 'bg-gradient-warning',
            default => 'bg-gradient-danger',
        };
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
