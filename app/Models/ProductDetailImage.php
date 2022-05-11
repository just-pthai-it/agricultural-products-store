<?php

namespace App\Models;

use Illuminate\Http\FileHelpers;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetailImage extends Model
{
    use HasFactory, FileHelpers;

    protected $fillable = [
        'id',
        'product_id',
        'image',
    ];

    public function product () : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
