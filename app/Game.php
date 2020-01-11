<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //

    protected $connection = 'mysql';
	protected $fillable = ['division_id', 'name', 'url'];

    /**
     * Scope a query to only include game of a given division_id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $division_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfDivision($query, $division_id)
    {
        return $query->whereIn('division_id', $division_id);
    }

}
