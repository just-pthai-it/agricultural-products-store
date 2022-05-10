<?php

namespace App\Models;

use Illuminate\Http\FileHelpers;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function product () : BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
