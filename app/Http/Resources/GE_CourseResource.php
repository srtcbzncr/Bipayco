<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GE_CategoryWithoutSubCategoriesResource;
use App\Http\Resources\GE_SubCategoryResource;

class GE_CourseResource extends JsonResource
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
            'image' => $this->image,
            'name' => $this->name,
            'description' => $this->description,
            'access_time' => $this->access_time,
            'certificate' => $this->certificate,
            'long' => $this->long,
            'price' => $this->price,
            'point' => $this->point,
            'purchase_count' => $this->purchase_count,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'discount' => new GE_DiscountResource($this->discount),
            'category' => new GE_CategoryWithoutSubCategoriesResource($this->category),
            'sub_category' => new GE_SubCategoryResource($this->subCategory),
        ];
    }
}
