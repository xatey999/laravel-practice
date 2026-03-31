<?php

namespace Modules\Categories\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Categories\Http\Requests\StoreProductRequest;
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
        $isManagementView = $user?->role === UserRoleEnum::ADMIN || $user?->role === UserRoleEnum::SUPPLIER;

        if ($isManagementView) {
            $products = $this->productService->getManagementProductsForUser($user, $search, $categoryId);
            $routePrefix = $this->productService->getRoutePrefixForUser($user);

            return view('categories::admin.products.index', [
                'products' => $products,
                'categories' => $categories,
                'routePrefix' => $routePrefix,
            ]);
        }

        $products = $this->productService->searchAndFilter($search, $categoryId);
        $manageProductsUrl = match ($user?->role) {
            UserRoleEnum::ADMIN => route('admin.products.index'),
            UserRoleEnum::SUPPLIER => route('supplier.products.index'),
            default => null,
        };
        $canAddToCart = $user?->role === UserRoleEnum::CUSTOMER;
        $showCartRestrictedMessage = $user !== null && ! $canAddToCart;
        $showLoginToPurchase = $user === null;

        return view('categories::products.index', [
            'products' => $products,
            'categories' => $categories,
            'manageProductsUrl' => $manageProductsUrl,
            'canAddToCart' => $canAddToCart,
            'showCartRestrictedMessage' => $showCartRestrictedMessage,
            'showLoginToPurchase' => $showLoginToPurchase,
            'searchValue' => $search,
            'selectedCategoryId' => $categoryId,
            'hasActiveFilters' => $search !== null || $categoryId !== null,
            'paginationQuery' => array_filter([
                'search' => $search,
                'category' => $categoryId,
            ], static fn ($value) => $value !== null && $value !== ''),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->productService->getAllCategories();
        $user = Auth::user();
        $routePrefix = $this->productService->getRoutePrefixForUser($user);
        $isAdmin = $routePrefix === 'admin';
        $suppliers = $this->productService->getSuppliersForForm($user);

        return view('categories::admin.products.create', compact('categories', 'suppliers', 'isAdmin', 'routePrefix'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $user = Auth::user();
        $validated = $this->productService->prepareProductDataForUser($request->validated(), $user);
        $this->productService->createProduct($validated, $request->file('images', []));
        $routePrefix = $this->productService->getRoutePrefixForUser($user);

        return redirect()->route($routePrefix.'.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the specified product with details
     */
    public function show(Product $product)
    {
        $product = $this->productService->getProductWithImages($product);
        $user = Auth::user();

        return view('categories::products.show', [
            'product' => $product,
            'canAddToCart' => $user?->role === UserRoleEnum::CUSTOMER,
            'showCartRestrictedMessage' => $user !== null && $user?->role !== UserRoleEnum::CUSTOMER,
            'showLoginToPurchase' => $user === null,
            'statusBadgeClass' => $this->resolveProductStatusBadgeClass($product->status->value),
            'statusLabel' => ucfirst(str_replace('_', ' ', $product->status->value)),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product = $this->productService->getProductWithImages($product);
        $categories = $this->productService->getAllCategories();
        $user = Auth::user();
        $routePrefix = $this->productService->getRoutePrefixForUser($user);
        $isAdmin = $routePrefix === 'admin';
        $suppliers = $this->productService->getSuppliersForForm($user);

        return view('categories::admin.products.edit', compact('product', 'categories', 'suppliers', 'isAdmin', 'routePrefix'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $user = Auth::user();
        $validated = $this->productService->prepareProductDataForUser($request->validated(), $user, $product);
        $this->productService->updateProduct(
            $product,
            $validated,
            $request->file('images', [])
        );

        $routePrefix = $this->productService->getRoutePrefixForUser($user);

        return redirect()->route($routePrefix.'.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);
        $user = Auth::user();
        $routePrefix = $this->productService->getRoutePrefixForUser($user);

        return redirect()->route($routePrefix.'.products.index')->with('success', 'Product deleted successfully.');
    }

    private function resolveProductStatusBadgeClass(string $status): string
    {
        return match ($status) {
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-red-100 text-red-800',
            default => 'bg-yellow-100 text-yellow-800',
        };
    }
}
