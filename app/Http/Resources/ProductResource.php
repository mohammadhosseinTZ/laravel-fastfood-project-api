<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,

            'category' => $this->whenLoaded('category'),

            'primary_image' => $this->primary_image,
            'description' => $this->description,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'sale_price' => $this->sale_price,
            'date_on_sale_from' => $this->date_on_sale_from,
            'date_on_sale_to' => $this->date_on_sale_to,
            'status' => (bool) $this->status,
            'images'=>$this->whenLoaded('images')
        ];
    }
}
