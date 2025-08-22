<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'object',
        'url',
        'name',
        'key',
        'active',
        'image',
        'created',
        'last_updated',
        'parent_id',
        'types',
    ];

    protected $casts = [
        'active' => 'boolean',
        'types' => 'array',
    ];
}
