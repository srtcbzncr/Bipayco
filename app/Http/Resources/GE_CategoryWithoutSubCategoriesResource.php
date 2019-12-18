<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GE_CategoryWithoutSubCategoriesResource extends JsonResource
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
            'symbol' => $this->symbol,
            'color' => $this->color,
            'active' => $this->active,
        ];
    }
}
