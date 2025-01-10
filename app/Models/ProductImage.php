<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
    ];

    protected $hidden = [
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // An image belongs to a product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
