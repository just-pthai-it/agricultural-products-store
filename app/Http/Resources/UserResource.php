<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class UserResource extends JsonResource
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
        return ['id'         => $this->id,
                'firstName' => $this->first_name,
                'lastName'  => $this->last_name,
                'email'      => $this->email,
                'phone'      => $this->phone,
                'address'    => $this->address,
                'image'      => $this->image,];
    }
}
