<?php

namespace skyimport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tracking extends Model
{
	use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'tracking', 'description', 'distributor_id', 'price', 'tstate_id', 'consolidated_id', 'shippingstate_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'updated_at', 'created_at', 'deleted_at'
    ];

    /**
     * Get the distributor that owns the tracking.
     */
    public function distributor()
    {
        return $this->belongsTo(\skyimport\Models\Distributor::class);
    }

    /**
     * Get the shippingstate that owns the tracking.
     */
    public function shippingstate()
    {
        return $this->belongsTo(\skyimport\Models\Shippingstate::class);
    }

    /**
     * Get the consolidated that owns the consolidated.
     */
    public function consolidated()
    {
        return $this->belongsTo(Consolidated::class);
    }

    /**
     * Get the eventsUsers that owns the consolidated.
     */
    public function eventsUsers()
    {
        return $this->hasMany(EventsUsers::class);
    }

}
