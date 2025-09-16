<?php

namespace App\Repository;

use App\Models\Product;

class ProductRepository
{
    public function getProductsWithSorting(string $sort, string $direction, int $perPage = 10): mixed
    {
        $query = Product::with('category');

        if ($sort === 'category') {
            $query->join('categories', 'products.category_id', '=', 'categories.id')
                ->orderBy('categories.name', $direction)
                ->select('products.*'); // Importante: evita conflitos de colunas duplicadas
        } else {
            $query->orderBy($sort, $direction);
        }

        return $query->paginate($perPage);
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }
}
