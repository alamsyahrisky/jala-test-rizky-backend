<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes,UuidTrait;

    protected $table = 'product';

    protected $fillable = [
        'sku',
        'name',
        'slug',
        'description',
        'price',
        'image',
        'category_id',
        'condition',
        'weight',
        'stok',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class,'product_id','id');
    }

    public function order()
    {
        return $this->belongsTo(OrderDetail::class,'product_id','id');
    }
}
