<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray ($request) : array
    {
        $this->productDetailImages = $this->productDetailImages->pluck('image');
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'description'  => $this->description,
            'categoryId'   => $this->category_id,
            'productUnit'  => $this->productUnit->name,
            'quantity'     => $this->productBatches[0]->quantity,
            'price'        => $this->price,
            'previewImage' => $this->preview_image,
            'image'        => $this->image,
            'detailImages' => $this->productDetailImages,
        ];
    }
}
