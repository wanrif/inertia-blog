<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, HasUuids, Sluggable, Searchable;

    protected $guarded = ['id'];

    protected $with = ['author'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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
                'source' => 'title'
            ]
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

    public function toSearchableArray()
{
    return [
        'title' => $this->title,
    ];
}
}