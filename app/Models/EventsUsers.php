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
    	'tracking_id', 'consolidated_id', 'event_id', 'viewed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'created_at', 'updated_at'
    ];

    /**
     * Get the events for the consolidated.
     */
    public function events()
    {
    	return $this->hasOne(Events::class, 'id', 'event_id');
    }

    /**
     * Get the consolidated that owns the EventsUsers.
     */
    public function consolidated()
    {
        return $this->belongsTo(Consolidated::class);
    }
}
