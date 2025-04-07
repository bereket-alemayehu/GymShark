<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'thumbnail',
        'blog_category_id',
        'content',
        'published_at',
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];
    public function blogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
