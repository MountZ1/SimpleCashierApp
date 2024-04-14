<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $fillable = [
        'invoice',
        'date',
        'total',
        'payment',
        'pay_amount',
        'change',
        'cashier'
    ];
    
    protected $with = ['detailpembelian'];
    
    public function detailpembelian(){
        return $this->hasMany(detail_transaksi::class, 'invoice', 'invoice');
    }

    use HasFactory;
}
