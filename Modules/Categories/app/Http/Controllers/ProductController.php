<?php

namespace Modules\Categories\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Categories\Models\Product;
use Modules\Categories\Services\ProductService;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
    ) {
        $this->authorizeResource(Product::class, 'product', [
            'except' => ['index', 'show'],
        ]);
    }

    /**
     * Display a listing of products with search and filter
     */
    public function index()
    {
        $search = request('search');
        $categoryId = request('category') ? (int) request('category') : null;
        $categories = $this->productService->getAllCategories();
        $user = Auth::user();

        if ($user?->role === UserRoleEnum::ADMIN) {
            $products = $this->productService->listForManagement($search, $categoryId, null);

            return view('categories::admin.products.index', [
                'products' => $products,
                'categories' => $categories,
                'routePrefix' => 'admin',
            ]);
        }

        if ($user?->role === UserRoleEnum::SUPPLIER) {
            $products = $this->productService->listForManagement($search, $categoryId, Auth::id());

            return view('categories::admin.products.index', [
                'products' => $products,
                'categories' => $categories,
                'routePrefix' => 'supplier',
            ]);
        }

        $products = $this->productService->searchAndFilter($search, $categoryId);

        return view('categories::products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->productService->getAllCategories();
        $user = Auth::user();
        $isAdmin = $user->role === UserRoleEnum::ADMIN;
        $suppliers = $isAdmin
            ? User::query()->where('role', UserRoleEnum::SUPPLIER)->orderBy('first_name')->orderBy('last_name')->get()
            : collect();
        $routePrefix = $isAdmin ? 'admin' : 'supplier';

        return view('categories::admin.products.create', compact('categories', 'suppliers', 'isAdmin', 'routePrefix'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        if ($user->role === UserRoleEnum::SUPPLIER) {
            $validated['supplier_id'] = Auth::id();
        }
        $validated['slug'] = Str::slug($request->name, '-');
        $this->productService->createProduct($validated);

        $routePrefix = $user->role === UserRoleEnum::ADMIN ? 'admin' : 'supplier';

        return redirect()->route($routePrefix.'.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the specified product with details
     */
    public function show(Product $product)
    {
        $product = $this->productService->getProductWithImages($product);

        return view('categories::products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = $this->productService->getAllCategories();
        $user = Auth::user();
        $isAdmin = $user->role === UserRoleEnum::ADMIN;
        $suppliers = $isAdmin
            ? User::query()->where('role', UserRoleEnum::SUPPLIER)->orderBy('first_name')->orderBy('last_name')->get()
            : collect();
        $routePrefix = $isAdmin ? 'admin' : 'supplier';

        return view('categories::admin.products.edit', compact('product', 'categories', 'suppliers', 'isAdmin', 'routePrefix'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $user = Auth::user();

        if ($user->role === UserRoleEnum::SUPPLIER) {
            unset($validated['supplier_id']);
        }
        if ($request->name !== $product->name) {
            $validated['slug'] = Str::slug($request->name, '-');
        }
        $this->productService->updateProduct($product, $validated);

        $routePrefix = $user->role === UserRoleEnum::ADMIN ? 'admin' : 'supplier';

        return redirect()->route($routePrefix.'.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);
        $user = Auth::user();

        $routePrefix = $user->role === UserRoleEnum::ADMIN ? 'admin' : 'supplier';

        return redirect()->route($routePrefix.'.products.index')->with('success', 'Product deleted successfully.');
    }
}
