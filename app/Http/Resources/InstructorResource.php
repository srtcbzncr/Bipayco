<?php

namespace App\Http\Resources;

use App\Models\Base\School;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
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
            'identification_number' => $this->identification_number,
            'title' => $this->title,
            'bio' => $this->bio,
            'iban' => $this->iban,
            'reference_code' => $this->reference_code,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'school' => new SchoolResource($this->school),
            'user' => new UserResource($this->user),
        ];
    }
}
