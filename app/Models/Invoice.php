<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory,SoftDeletes,UuidTrait;

    protected $table = 'invoice';

    protected $fillable = [
        'number',
        'date',
        'note',
        'company',
        'price_total',
        'item_total',
    ];

    public function detail()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id', 'id');
    }

}
