<?php

namespace App\Models;

use Illuminate\Http\FileHelpers;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory, FileHelpers;

    protected $fillable = [
        'id',
        'name',
        'type',
    ];

    public function product () : HasMany
    {
        return $this->hasMany(Product::class, 'product_id', 'id');
    }
}
