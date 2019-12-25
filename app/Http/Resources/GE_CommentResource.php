<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GE_CommentResource extends JsonResource
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
            'content' => $this->content,
            'point' => $this->point,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'course' => new GE_CourseResource($this->course),
            'user' => new UserResource($this->user),
        ];
    }
}
