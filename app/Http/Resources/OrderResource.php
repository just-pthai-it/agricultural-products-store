<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id'        => $this->id,
            'userId'    => $this->user_id,
            'total'     => $this->total,
            'createdAt' => $this->created_at->format('Y-m-d H:m:i'),
            'updatedAt' => $this->updated_at->format('Y-m-d H:m:i'),
        ];
    }
}
