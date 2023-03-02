<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockDetail extends Model
{
    use HasFactory,UuidTrait;

    protected $table = 'stock_detail';

    protected $fillable = [
        'stock_id',
        'type',
        'quantity',
        'number',
    ];

    protected $casts= [
        'created_at' => 'date:Y-m:d H:i:s',
        'updated_at' => 'date:Y-m:d H:i:s',
    ];
}
