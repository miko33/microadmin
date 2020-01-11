<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    //

    /**
     * Scope a query to only include division of a given id's.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfId($query, $id)
    {
        // dd($query, $id);
        return $query->whereIn('id', $id);
    }

}
