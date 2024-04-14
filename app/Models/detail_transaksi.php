<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_transaksi extends Model
{
    protected $fillable = [
        'invoice',
        'product_id',
        'qty',
    ];

    // protected $with = ['Product', 'transaksi'];
    
    public function Product(){
        return $this->hasMany(product::class, 'id', 'product_id');
    }
    
    public function transaksi(){
        return $this->belongsTo(transaksi::class, 'invoice', 'invoice');
    }
    
    use HasFactory;

}
