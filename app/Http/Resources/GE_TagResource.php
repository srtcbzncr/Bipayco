<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GE_TagResource extends JsonResource
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
            'tag' => $this->tag,
        ];
    }
}
