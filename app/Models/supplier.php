<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class supplier extends Model
{
    protected $fillable=[
        'company_name',
        'email',
        'phone',
        'address'
    ];

    public function product(): HasMany{
        return $this->hasMany(product::class);
    }
    
    use HasFactory;
}
