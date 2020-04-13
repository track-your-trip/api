<?php

namespace App;

use App\Trip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'trip_id',
        'name',
        'description',
        'beginn',
        'end',
        'lat',
        'lng'
    ];

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

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
