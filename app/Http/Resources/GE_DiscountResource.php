<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GE_DiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'discount_rate' => $this->discount_rate,
            'price_with_discount' => $this->price_with_discount,
            'start_date' => $this->start_date,
            'finish_date' => $this->finish_date,
            'active' => $this->active,
        ];
    }
}
