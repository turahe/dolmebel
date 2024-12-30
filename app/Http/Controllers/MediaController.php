<?php

namespace App\Http\Controllers;

use App\Contracts\ProductRepositoryInterface;
use App\Http\Resources\MediaResource;
use App\Models\Media;

class MediaController extends Controller
{
    public function __invoke(string $id)
    {
        //        $product = app(ProductRepositoryInterface::class)->getProduct($id);
        //        $media = $product->media;
        $media = Media::all();

        return MediaResource::collection($media);
    }
}
