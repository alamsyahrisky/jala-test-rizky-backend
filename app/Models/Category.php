<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'category';

    protected $fillable = [
        'code',
        'name',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'category_id','id');
    }

    protected $appends = ['value'];
  
    public function getValueAttribute()
    {
        $total = DB::table('order_detail')
            ->join('product', 'product.id', '=', 'order_detail.product_id')
            ->join('category', 'category.id', '=', 'product.category_id')
            ->where('category.id',$this->id)
            ->sum('quantity');

        return ($total ? $total : 0);
    }
}
