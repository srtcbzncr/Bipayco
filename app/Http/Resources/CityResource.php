<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
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
            'error' => false,
            'id' => $this->id,
            'country' => new CountryResource($this->country),
            'code' => $this->code,
            'name' => $this->name,
            'active' => $this->active,
        ];
    }
}
