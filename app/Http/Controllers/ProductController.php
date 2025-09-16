<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $allowedSorts = ['id', 'name', 'price', 'quantity', 'status', 'description', 'category'];
        $sort = $this->validateSort($request->input('sort', 'id'), $allowedSorts, 'id');
        $direction = $this->validateDirection($request->input('direction'), 'asc');

        $query = Product::with('category');

        if ($sort === 'category') {
            $query->join('categories', 'products.category_id', '=', 'categories.id')
                ->orderBy('categories.name', $direction)
                ->select('products.*'); // Importante: evita conflitos de colunas duplicadas
        } else {
            $query->orderBy($sort, $direction);
        }

        $products = $query->paginate(10);

        return view('product.index', compact('products', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('product.create', [
            'categories' => $categories,
            'statuses' => Status::cases()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:' . implode(',', array_map(fn ($case) => $case->value, Status::cases())),
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store("products", "public");
            $validated['image'] = basename($path);
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
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
