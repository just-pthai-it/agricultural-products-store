<?php

namespace App\Models;

use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'id',
        'name',
        'description',
        'category_id',
        'product_unit_id',
        'price',
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function category () : BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function productUnit () : HasOne
    {
        return $this->hasOne(ProductUnit::class, 'product_unit_id', 'id');
    }

    public function productBatches () : HasMany
    {
        return $this->hasMany(ProductBatch::class, 'product_id', 'id');
    }

    public function users () : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'carts', 'product_id', 'user_id')
                    ->withPivot(['quantity']);
    }

    public function orders () : BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
                    ->withPivot(['quantity', 'price']);
    }
}
