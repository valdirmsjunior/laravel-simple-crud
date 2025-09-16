<?php

namespace App\Repository;

use App\Models\Category;

class CategoryRepository
{
    public function getAllCategories(): mixed
    {
        return Category::all();
    }
}
