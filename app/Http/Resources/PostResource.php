<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostResource extends ResourceCollection
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
            "id" => $this->id, 
            "user" => $this->user, 
            "title" => $this->title, 
            "description" => $this->description,
            "tags" => $this->tags, 
            "status" => $this->status, 
            "created_at" => $this->created_at, 
            "updated_at" => $this->updated_at
        ];
    }
}
