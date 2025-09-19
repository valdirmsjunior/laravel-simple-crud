<?php

namespace App\Services;

use App\Enums\Status;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Illuminate\Support\Facades\Storage;

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

    public function getProductById(int $id): ?object
    {
        return $this->productRepository->findById($id);
    }

    public function getTrashedProducts(?string $search, int $perPage = 10): mixed
    {
        return $this->productRepository->getTrashedProductsWithSearch($search, $perPage);
    }

    public function getTrashedProductById(int $id): ?object
    {
        return $this->productRepository->getTrashedProductById($id);
    }

    public function restoreProduct(int $id): void
    {
        $this->productRepository->restore($id);
    }

    public function findProductById(int $id): ?object
    {
        return $this->productRepository->findById($id);
    }

    public function getAllCategories(): mixed
    {
        return $this->categoryRepository->getAllCategories();
    }

    public function updateProduct(UpdateProductRequest $request, int $id): void
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($request->image && Storage::disk('public')->exists($request->image)) {
                Storage::disk('public')->delete($request->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $this->productRepository->update($id, $data);
    }

    public function deleteProduct(int $id): void
    {
        $this->productRepository->delete($id);
    }
}
