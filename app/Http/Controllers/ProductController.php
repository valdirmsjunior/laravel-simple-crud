<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected int $perPage = 10;
    public function __construct(
        protected ProductService $productService,
    ) {
        $this->productService = $productService;
    }

    public function index(Request $request): View
    {
        $allowedSorts = ['id', 'name', 'price', 'quantity', 'status', 'description', 'category'];
        $sort = $this->validateSort($request->input('sort', 'id'), $allowedSorts, 'id');
        $direction = $this->validateDirection($request->input('direction'), 'asc');
        $search = $request->input('search');

        $products = $this->productService->getPaginatedProducts($sort, $direction, $search, $this->perPage);

        return view('product.index', compact('products', 'sort', 'direction', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $data = $this->productService->getCreateFormData();

        return view('product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $this->productService->createProduct($request);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product = $this->productService->getProductById($product->id);
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $categories = $this->productService->getAllCategories();
        $product = $this->productService->findProductById($product->id);
        return view(
            'product.edit',
            [
            'categories' => $categories,
            'product' => $product,
            'statuses' => Status::cases()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $this->productService->updateProduct($request, $product->id);
        $page = $this->productService->getProductPage($product->id, $this->perPage);

        return redirect()->route('products.index', ['highlight' => $product->id, 'page' => $page])->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->productService->deleteProduct($product->id);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function trashedProducts(Request $request): View
    {
        $allowedSorts = ['id', 'name', 'price', 'quantity', 'status', 'description', 'category'];
        $sort = $this->validateSort($request->input('sort', 'id'), $allowedSorts, 'id');
        $direction = $this->validateDirection($request->input('direction'), 'asc');
        $search = $request->input('search');
        $deletedProducts = $this->productService->getTrashedProducts($search, 10);

        return view('product.deleted-products', compact('deletedProducts', 'sort', 'direction', 'search'));
    }

    public function showTrashed(int $id): View
    {
        $product = $this->productService->getTrashedProductById($id);

        return view('product.show', compact('product'));
    }

    public function restoreProduct(int $id): RedirectResponse
    {
        $this->productService->restoreProduct($id);

        return redirect()->route('products.trashed')->with('success', 'Product restored successfully.');
    }

    private function validateSort(?string $sort, array $allowedSorts, string $default): string
    {
        return in_array($sort, $allowedSorts) ? $sort : $default;
    }

    private function validateDirection(?string $direction, string $default): string
    {
        return in_array($direction, ['asc', 'desc']) ? $direction : $default;
    }
}
