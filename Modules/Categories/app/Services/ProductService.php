<?php

namespace Modules\Categories\Services;

use App\DataTransferObjects\ProductDTO;
use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Categories\Models\Category;
use Modules\Categories\Models\Product;
use Modules\Categories\Models\ProductImage;
use Modules\Categories\Actions\CreateProductAction;
use Modules\Categories\Repositories\ProductRepository;

class ProductService
{
    private const PUBLIC_DISK = 'public';
    private const MAX_SLUG_LENGTH = 150;

    public function __construct(
        private ProductRepository $repository,
        private CreateProductAction $createAction,
        private FileUploadService $fileUploadService,
    ) {}

    public function getFeaturedProducts(int $limit = 8)
    {
        return $this->repository->getFeaturedProducts($limit);
    }

    public function getAllCategories()
    {
        return $this->repository->getAllCategories();
    }

    public function searchAndFilter(
        ?string $search = null,
        ?int $categoryId = null,
        int $perPage = 12
    ) {
        return $this->repository->searchAndFilter($search, $categoryId, $perPage);
    }

    public function listForManagement(?string $search, ?int $categoryId, ?int $supplierId = null)
    {
        return $this->repository->listForManagement($search, $categoryId, $supplierId);
    }

    public function getRoutePrefixForUser(User $user): string
    {
        return $user->role === UserRoleEnum::ADMIN ? 'admin' : 'supplier';
    }

    public function getSuppliersForForm(User $user): Collection
    {
        if ($user->role !== UserRoleEnum::ADMIN) {
            return collect();
        }

        return User::query()
            ->where('role', UserRoleEnum::SUPPLIER)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();
    }

    public function getManagementProductsForUser(User $user, ?string $search, ?int $categoryId)
    {
        $supplierId = $user->role === UserRoleEnum::SUPPLIER ? $user->id : null;

        return $this->listForManagement($search, $categoryId, $supplierId);
    }

    public function getProductWithImages(Product $product)
    {
        return $this->repository->getWithImages($product);
    }

    public function createProduct(array $data, array $images = []): Product
    {
        $data = $this->applySlugForCreate($data);

        return DB::transaction(function () use ($data, $images) {
            $productDTO = ProductDTO::fromArray($data);
            $product = $this->createAction->execute($productDTO);

            $uploadedImages = $this->filterUploadedFiles($images);
            if ($uploadedImages !== []) {
                $this->storeProductImages($product, $uploadedImages);
            }

            return $product->fresh(['images']);
        });
    }

    public function prepareProductDataForUser(array $data, User $user, ?Product $product = null): array
    {
        if ($user->role === UserRoleEnum::SUPPLIER) {
            $data['supplier_id'] = $user->id;
        }

        if ($product !== null && isset($data['name']) && $data['name'] !== $product->name) {
            $data['slug'] = $this->buildProductSlug($data['name']);
        }

        return $data;
    }

    public function updateProduct(Product $product, array $data, array $images = []): Product
    {
        return DB::transaction(function () use ($product, $data, $images) {
            $removeImageIds = $data['remove_image_ids'] ?? [];
            unset($data['remove_image_ids']);

            if (! array_key_exists('supplier_id', $data)) {
                $data['supplier_id'] = $product->supplier_id;
            }

            $productDTO = ProductDTO::fromArray($data);
            $product->update($productDTO->toArray());

            if (is_array($removeImageIds) && $removeImageIds !== []) {
                $this->removeProductImages($product->fresh(), $removeImageIds);
            }

            $uploadedImages = $this->filterUploadedFiles($images);
            if ($uploadedImages !== []) {
                $this->storeProductImages($product->fresh(), $uploadedImages);
            }

            return $product->fresh(['images']);
        });
    }

    public function deleteProduct(Product $product): bool
    {
        return $this->repository->delete($product);
    }

    /**
     * @param array<int, UploadedFile> $images
     */
    private function storeProductImages(Product $product, array $images): void
    {
        $directory = $this->buildProductDirectory($product);
        $hasPrimaryImage = $product->images()->where('is_primary', true)->exists();

        foreach ($images as $image) {
            $storedPath = $this->fileUploadService->store($image, $directory, self::PUBLIC_DISK);

            ProductImage::query()->create([
                'product_id' => $product->id,
                'image_path' => $storedPath,
                'is_primary' => ! $hasPrimaryImage,
            ]);

            $hasPrimaryImage = true;
        }
    }

    private function removeProductImages(Product $product, array $imageIds): void
    {
        $images = $product->images()->whereIn('id', $imageIds)->get();
        $removedPrimary = false;

        foreach ($images as $image) {
            if ($image->is_primary) {
                $removedPrimary = true;
            }

            $this->fileUploadService->delete($image->image_path, self::PUBLIC_DISK);
            $image->delete();
        }

        if ($removedPrimary) {
            $this->ensurePrimaryImageExists($product);
        }
    }

    private function ensurePrimaryImageExists(Product $product): void
    {
        if ($product->images()->where('is_primary', true)->exists()) {
            return;
        }

        $firstImageId = $product->images()->orderBy('id')->value('id');
        if ($firstImageId) {
            ProductImage::query()->where('id', $firstImageId)->update(['is_primary' => true]);
        }
    }

    /**
     * @param array<int, mixed> $images
     * @return array<int, UploadedFile>
     */
    private function filterUploadedFiles(array $images): array
    {
        return array_values(array_filter(
            $images,
            static fn ($image): bool => $image instanceof UploadedFile
        ));
    }

    private function buildProductDirectory(Product $product): string
    {
        $category = Category::query()->select(['id', 'name', 'slug'])->find($product->category_id);
        $categorySegment = $category?->slug ?: Str::slug($category?->name ?? 'uncategorized', '-');
        $productSegment = $product->slug ?: Str::slug($product->name, '-');

        return 'products/'.$categorySegment.'/'.$productSegment;
    }

    private function applySlugForCreate(array $data): array
    {
        if (isset($data['name'])) {
            $data['slug'] = $this->buildProductSlug($data['name']);
        }

        return $data;
    }

    private function buildProductSlug(string $name): string
    {
        return Str::limit(Str::slug($name, '-'), self::MAX_SLUG_LENGTH, '');
    }
}
