<?php

namespace Tests\Feature;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class PurchaseOrderTest extends TestCase
{
    public function test_purchase_order_exposes_its_items_as_a_has_many_relationship(): void
    {
        $purchaseOrder = new PurchaseOrder;

        $items = $purchaseOrder->items();

        $this->assertInstanceOf(HasMany::class, $items);
        $this->assertSame(PurchaseOrderItem::class, $items->getRelated()::class);
        $this->assertSame('purchase_order_id', $items->getForeignKeyName());
    }
}
