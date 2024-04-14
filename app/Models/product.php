<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class product extends Model
{
    protected $fillable=[
        'merk',
        'company_id',
        'code',
        'name',
        'buy_price',
        'sell_price',
        'stock',
        'category',
    ];

    protected $with = ['supplier'];

    public function supplier(): BelongsTo {
        return $this->belongsTo(supplier::class, 'company_id', 'id');
    }

    use HasFactory;
}
