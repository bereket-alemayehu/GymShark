<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'blogs' => BlogResource::collection($this->whenLoaded('blogs')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
