<?php

namespace App\traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait Searchable
{

    /**
     * Scope a query to search for a term in the attributes
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query)
    {

        [$searchTerm, $attributes] = $this->parseArguments(func_get_args());


        if (! $searchTerm || ! $attributes) {

            return $query;
        }


        return $query->where(function (Builder $query) use ($attributes, $searchTerm) {

            foreach (Arr::wrap($attributes) as $attribute) {

                $query->when(
                    str_contains($attribute, '.'),

                    function (Builder $query) use ($attribute, $searchTerm) {

                        [$relationName, $relationAttribute] = explode('.', $attribute);

                        $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {

                            $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                        });
                    },

                    function (Builder $query) use ($attribute, $searchTerm) {

                        $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                    }
                );
            }
        });
    }



    /**
     * Parse search scope arguments
     *
     * @param array $arguments
     * @return array
     */
    private function parseArguments(array $arguments)
    {

        $args_count = count($arguments);


        return match ($args_count) {
            1 => [request('search'), $this->searchableAttributes()],
            2 => is_string($arguments[1]) ? [$arguments[1], $this->searchableAttributes()] : [request('search'), $arguments[1]],
            3 => is_string($arguments[1]) ? [$arguments[1], $arguments[2]] : [$arguments[2], $arguments[1]],
            default => [null, []],
        };
    }

    /**
     * Get searchable columns
     *
     * @return array
     */
    public function searchableAttributes()
    {

        if (method_exists($this, 'searchable')) {

            return $this->searchable();
        }


        return property_exists($this, 'searchable') ? $this->searchable : [];
    }
}
