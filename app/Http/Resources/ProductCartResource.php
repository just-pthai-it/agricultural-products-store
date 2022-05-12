<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCartResource extends JsonResource
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
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'description'  => $this->description,
            'categoryId'   => $this->category_id,
            'productUnit'  => $this->productUnit->name,
            'quantity'     => $this->pivot->quantity,
            'maxQuantity'  => $this->productBatches[0]->quantity,
            'price'        => $this->price,
            'image'        => $this->image,
            'previewImage' => $this->preview_image,
        ];
    }
}
