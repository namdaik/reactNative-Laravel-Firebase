<?php

namespace App\Traits;

trait FullTextSearch
{


    /**
     * Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, ...$columns)
    {
        $keyWord = request()->search;
        if ($keyWord) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', "%$keyWord%");
            }
        }
        return $query;
    }
}
