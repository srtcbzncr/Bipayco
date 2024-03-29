<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GE_SubCategoryResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->color,
            'symbol' => $this->symbol,
            'active' => $this->active,
        ];
    }
}
