<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, HasUlids, Sluggable, Searchable;

    protected $guarded = ['id'];

    /**
     * Get the author for the post.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category for the post.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the slug from title.
     *
     * @return string
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'like', '%'.$search.'%')
                ->orWhereHas('author', fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
                ->orWhereHas('category', fn ($query) => $query->where('name', 'like', '%'.$search.'%'));
        });

        // $query->when($filters['category'] ?? null, fn ($query, $category) =>
        //         $query->whereHas('category', fn ($query) =>
        //             $query->where('name', $category)
        //     )
        // );
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'users.name' => '',
            'categories.name' => '',
        ];
    }
}
