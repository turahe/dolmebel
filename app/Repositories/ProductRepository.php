<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Turahe\Core\Repositories\BaseRepository;
use Turahe\Media\MediaUploader;
use Turahe\Post\Models\Post;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
        $this->model = $model;

    }

    public function getProductsBuilder(string $order = 'created_at', string $sort = 'desc'): Builder
    {
        return $this->model->query()->orderBy($order, $sort);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProducts(string $order = 'created_at', string $sort = 'desc', $except = []): Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    /**
     * @throws \Exception
     */
    public function getProduct(string $id): Product
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function getProductBySlug(string $slug): Product
    {
        try {
            return $this->model->whereHas('post', function (Builder $builder) use ($slug): void {
                $builder->where('slug', $slug);
            })->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    /**
     * @throws \Throwable
     */
    public function createProduct(array $attributes): Product
    {
        if (empty($attributes['language'])) {
            $attributes['language'] = config('app.locale');
        }

        return DB::transaction(function () use ($attributes) {
            $post = Post::create([
                'title' => $attributes['title'],
                'subtitle' => $attributes['subtitle'] ?? null,
                'description' => $attributes['description'] ?? null,
                'language' => $attributes['language'],
                'type' => 'product',
            ]);

            $product = $this->model->create([
                'qrcode' => $attributes['qrcode'],
                'barcode' => $attributes['barcode'],
                'supplier_id' => $attributes['supplier_id'] ?? null,
                'manufacture_id' => $attributes['manufacture_id'] ?? null,
                'category_id' => $attributes['category_id'] ?? null,
                'brand_id' => $attributes['brand_id'] ?? null,
                'post_id' => $post->id,
            ]);

            $product->setContents($attributes['content']);

            return $product;
        });
    }

    /**
     * @throws \Throwable
     */
    public function updateProduct(array $attributes): bool
    {
        if (empty($attributes['language'])) {
            $attributes['language'] = config('app.locale');
        }

        $productData = array_filter([
            'qrcode' => $attributes['qrcode'],
            'barcode' => $attributes['barcode'],
            'supplier_id' => $attributes['supplier_id'] ?? null,
            'manufacture_id' => $attributes['manufacture_id'] ?? null,
            'category_id' => $attributes['category_id'] ?? null,
            'brand_id' => $attributes['brand_id'] ?? null,
        ]);
        $postData = array_filter([
            'title' => $attributes['title'] ?? null,
            'subtitle' => $attributes['subtitle'] ?? null,
            'description' => $attributes['description'] ?? null,
            'language' => $attributes['language'],
            'type' => 'product',
        ]);

        return DB::transaction(function () use ($productData, $postData) {
            if (isset($post['title']) || isset($post['subtitle']) || isset($post['description'])) {
                Post::where('post_id', $this->model->getKey())->update($postData);
            }

            return $this->model->update($productData);
        });
    }

    public function saveProductImages(Collection $collection): void
    {
        $collection->each(function (UploadedFile $file) {
            $media = MediaUploader::fromFile($file)->upload();
            $this->model->attachMedia($media);
        });
    }

    /**
     * @return mixed
     */
    public function findProductImages(): Collection
    {
        return $this->model->media;
    }

    /**
     * @throws \Exception
     */
    public function deleteProduct(): bool
    {
        try {
            return $this->model->forceDelete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function trashProduct(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function addToWishlist(): bool
    {
        try {
            return $this->model->delete();
        } catch (QueryException $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}
