<?php

namespace App\Filters;

class BookFilters extends QueryFilter
{
    public function author($author)
    {
        return $this->builder->where('author', 'like', "%$author%");
    }

    public function search($keyword)
    {
        return $this->builder->where('title', 'like', "%$keyword%");
    }
}
