<?php

namespace App\Services;

use App\Enums\Status;
use App\Http\Requests\Product\StoreProductRequest;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected CategoryRepository $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function createProduct(StoreProductRequest $request): void
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store("products", "public");
            $data['image'] = basename($path);
        }

        $this->productRepository->create($data);
    }

    public function getPaginatedProducts(string $sort, string $direction, ?string $search, int $perPage = 10): mixed
    {
        return $this->productRepository->getProductsWithSortingAndSearch($sort, $direction, $search, $perPage);
    }

    public function getCreateFormData(): array
    {
        return [
            'categories' => $this->categoryRepository->getAllCategories(),
            'statuses' => Status::cases()
        ];
    }

    public function getTrashedProducts(?string $search, int $perPage = 10): mixed
    {
        return $this->productRepository->getTrashedProductsWithSearch($search, $perPage);
    }
}
