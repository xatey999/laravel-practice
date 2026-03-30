<?php

namespace Modules\Categories\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Str;
use Modules\Categories\Models\Category;
use Modules\Categories\Services\CategoryService;

class CategoriesController extends Controller
{
    public function __construct(
        private CategoryService $categoryService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        if (auth()->user()?->role->value === UserRoleEnum::ADMIN->value) {
            return view('categories::admin.categories.index', compact('categories'));
        }

        return view('categories::index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('categories::admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($request->name, '-');
        $this->categoryService->createCategory($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(Category $category)
    {
        $category = $this->categoryService->getCategoryWithProducts($category);
        $products = $category->products->map(function ($product) {
            $firstImage = $product->images->first();

            return [
                'name' => $product->name,
                'description' => Str::limit($product->description, 50),
                'price' => $product->price,
                'stock' => $product->stock,
                'show_url' => route('products.show', $product),
                'image_url' => $firstImage
                    ? asset('storage/' . $firstImage->image_path)
                    : asset('images/product-placeholder.svg'),
            ];
        });

        return view('categories::show', compact('category', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = $this->categoryService->getAllCategories();
        return view('categories::admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->categoryService->updateCategory($category, $request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->categoryService->deleteCategory($category);
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
