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
            'links' => [
                'self' => route('blog-categories.show', $this->id),
                'blogs' => route('blogs.index', ['category_id' => $this->id]),
                'related' => route('blog-categories.index'),
                'first' => route('blog-categories.index', ['page' => 1]),
                'last' => route('blog-categories.index', ['page' => $this->lastPage()]),
                'next' => $this->hasMorePages() ? route('blog-categories.index', ['page' => $this->currentPage() + 1]) : null,
                'prev' => $this->onFirstPage() ? null : route('blog-categories.index', ['page' => $this->currentPage() - 1]),
                'first_page' => route('blog-categories.index', ['page' => 1]),
                'last_page' => route('blog-categories.index', ['page' => $this->lastPage()]),
                'next_page' => $this->hasMorePages() ? route('blog-categories.index', ['page' => $this->currentPage() + 1]) : null,
                'prev_page' => $this->onFirstPage() ? null : route('blog-categories.index', ['page' => $this->currentPage() - 1]),
                'first_page_url' => route('blog-categories.index', ['page' => 1]),
                'last_page_url' => route('blog-categories.index', ['page' => $this->lastPage()]),
                'next_page_url' => $this->hasMorePages() ? route('blog-categories.index', ['page' => $this->currentPage() + 1]) : null,
                'prev_page_url' => $this->onFirstPage() ? null : route('blog-categories.index', ['page' => $this->currentPage() - 1]),
                'path' => route('blog-categories.index'),
                'current_page' => $this->currentPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ]
        ];
    }
}
