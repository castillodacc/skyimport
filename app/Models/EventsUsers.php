<?php

namespace skyimport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventsUsers extends Model
{
	use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tracking_id', 'consolidated_id', 'event_id', 'viewed', 'created_at'
    ];

    protected $date = ['created_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'updated_at', 'deleted_at'
    ];

    /**
     * Get the events for the EventsUsers.
     */
    public function events()
    {
    	return $this->hasOne(Events::class, 'id', 'event_id');
    }

    /**
     * Get the consolidated that owns the EventsUsers.
     */
    // public function consolidated()
    // {
    //     return $this->belongsTo(Consolidated::class);
    // }

    /**
     * Get the tracking that owns the EventsUsers.
     */
    // public function trackings()
    // {
    //     return $this->belongsTo(\skyimport\Models\Trackings::class);
    // }
}
