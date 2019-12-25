<?php

namespace App\Http\Resources;

use App\Models\Auth\User;
use Illuminate\Http\Resources\Json\JsonResource;

class GuardianResource extends JsonResource
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
            'reference_code' => $this->reference_code,
            'active' => $this->active,
            'user' => new UserResource($this->user),
        ];
    }
}
