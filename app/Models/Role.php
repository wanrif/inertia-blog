<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Role extends \Spatie\Permission\Models\Role
{
    use Searchable;

    // public function scopeFilter($query, array $filters)
    // {
    //     $query->when($filters['search'] ?? false, fn($query, $search) =>
    //         $query->where('name', 'like', '%' . $search . '%')
    //     );
    // }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
        ];
    }
}