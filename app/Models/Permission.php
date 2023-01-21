<?php

namespace App\Models;

use Laravel\Scout\Searchable;

class Permission extends \Spatie\Permission\Models\Permission
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
