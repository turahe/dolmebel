<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string $code
 * @property string $description
 * @property string $image
 * @property string $icon
 * @property string $parent_id
 * @property \Illuminate\Support\Collection $products
 * @property \Illuminate\Support\Collection $blogs
 */
class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'description' => $this->description,
            'image' => $this->image,
            'icon' => $this->icon,
            'parent_id' => $this->parent_id,
            'count' => $this->getCountRelation($request->get('relation')),
        ];
    }

    private function getCountRelation(string $relation): int
    {
        $count = 0;
        if ($relation === 'products') {
            $count = $this->products->count();
        }
        if ($relation === 'blogs') {
            $count = $this->blogs->count();
        }

        return $count;
    }
}
