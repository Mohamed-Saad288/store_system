<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;
trait SearchTrait
{
    public function scopeSearch(Builder $query, array $data)
    {
        if (isset($data['search']) && !empty($data['search'])) {
            $searchTerm = $data['search'];

            if (property_exists($this, 'searchable') && is_array($this->searchable)) {
                $query->where(function ($query) use ($searchTerm) {
                    foreach ($this->searchable as $column) {
                        $query->orWhere($column, 'LIKE', "%{$searchTerm}%");
                    }
                });
            }
        }

        return $query;
    }
}
