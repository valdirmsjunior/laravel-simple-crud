<?php

namespace App\Repository;

use App\Models\Product;

class ProductRepository
{
    public function getProductsWithSortingAndSearch(string $sort, string $direction, ?string $search, int $perPage = 10): mixed
    {
        $query = Product::with('category')->search($search);

        if ($sort === 'category') {
            $query->join('categories', 'products.category_id', '=', 'categories.id')
                ->orderBy('categories.name', $direction)
                ->select('products.*'); // Importante: evita conflitos de colunas duplicadas
        } else {
            $query->orderBy($sort, $direction);
        }

        // Mantém os parâmetros de URL atuais para preservar estado ao navegar entre páginas.
        // Isso garante que ao navegar entre as páginas, filtros e ordenações não sejam perdidos.
        return $query->paginate($perPage)->withQueryString();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function getTrashedProductsWithSearch(?string $search, int $perPage): mixed
    {
        $query = Product::onlyTrashed()->search($search);

        return $query->paginate($perPage)->withQueryString();
    }
}
