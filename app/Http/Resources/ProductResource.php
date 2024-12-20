<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $qrcode
 * @property string $barcode
 * @property string $slug
 * @property string $name
 * @property string $image
 * @property \App\Models\Category $category
 * @property \App\Models\Supplier $supplier
 * @property \App\Models\Brand $brand
 * @property \App\Models\Manufacture $manufacture
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'qrcode' => $this->qrcode,
            'barcode' => $this->barcode,
            'url' => route('product.show', $this->slug),
            'name' => $this->name,
            'image' => $this->image,
            'images' => MediaResource::collection($this->whenLoaded('media')),
            'price' => new PriceResource($this->price),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'supplier' => new SupplierResource($this->whenLoaded('supplier')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'manufacture' => new ManufactureResource($this->whenLoaded('manufacture')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
