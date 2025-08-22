<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function productTypes(): BelongsToMany
    {
        return $this->belongsToMany(ProductType::class, 'product_product_type');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    protected $fillable = [
        'name',
        'short_name',
        'part_number',
        'store_id',
        'shipping_group',
        'active',
        'visible_on_store',
        'description',
        'short_description',
        'website_url',
        'types',
        'images',
        'price',
        'base_dimensions',
        'shipping_dimensions',
        'created',
        'updated',
    ];

    protected $casts = [
        'api_id' => 'integer',
        'active' => 'boolean',
        'visible_on_store' => 'boolean',
        'types' => 'array',
        'images' => 'array',
        'price' => 'array',
        'base_dimensions' => 'array',
        'shipping_dimensions' => 'array',
    ];
}
