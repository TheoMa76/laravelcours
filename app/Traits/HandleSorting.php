<?php

namespace App\Traits;

trait HandleSorting
{
    protected function applySorting($query, $validSorts, $relationSorts, $defaultSort = 'id')
    {
        $sort = request()->get('sort', $defaultSort);
        $direction = request()->get('direction', 'asc');

        $sort = in_array($sort, array_merge($validSorts, $relationSorts)) ? $sort : $defaultSort;
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';

        if (!in_array($sort, $relationSorts)) {
            $query->orderBy($sort, $direction);
        }

        return [$sort, $direction];
    }

    protected function sortCollection($collection, $sort, $direction, $relationSorts)
    {
        if (in_array($sort, $relationSorts)) {
            return $direction === 'asc' 
                ? $collection->sortBy($sort)
                : $collection->sortByDesc($sort);
        }
        return $collection;
    }
}