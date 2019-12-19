<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GE_SubCategoryCollection;

class GE_CategoryResource extends JsonResource
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
            'sub_categories' => new GE_SubCategoryCollection($this->subCategories),
        ];
    }
}
