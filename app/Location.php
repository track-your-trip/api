<?php

namespace App;

use App\Trip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
    	'beginn',
    	'end',
    	'deleted_at'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
