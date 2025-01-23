<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'id'                  => 'integer',
        'product_category_id' => 'integer',
    ];

    protected $hidden = [
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Relation: A blog belongs to a category
    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    // A product can have multiple images
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // One Product has many Benefits
    public function benefits()
    {
        return $this->hasMany(ProductBenefit::class);
    }

    public function orderProduct()
    {
        return $this->belongsToMany(OrderPuduct::class, 'order_products');
    }
    
}
