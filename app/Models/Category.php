<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'status'];

    protected $casts = [
        'status' => Status::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
