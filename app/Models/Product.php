<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public const CATEGORIES = [
        'tops' => 'Tops',
        'bottoms' => 'Bottoms',
        'dresses' => 'Dresses',
        'outerwear' => 'Outerwear',
        'accessories' => 'Accessories',
        'other' => 'Other',
    ];

    public const FEBRIC_TYPES = [
        'cotton' => 'Cotton',
        'polyester' => 'Polyester',
        'denim' => 'Denim',
        'linen' => 'Linen',
        'silk' => 'Silk',
        'wool' => 'Wool',
        'other' => 'Other',
    ];

    public const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];

    protected $fillable = [
        'product_code',
        'product_name',
        'category',
        'febric_type',
        'description',
        'status',
    ];
}
