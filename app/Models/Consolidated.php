<?php

namespace skyimport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consolidated extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'user_id', 'shippingstate_id', 'closed_at', 'created_at'
    ];

    protected $dates = [
        'closed_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];

    /**
     * Get the user that owns the consolidated.
     */
    public function user()
    {
        return $this->belongsTo(\skyimport\User::class);
    }

    /**
     * Get the Shippingstate that owns the consolidated.
     */
    public function Shippingstate()
    {
        return $this->belongsTo(Shippingstate::class);
    }

    /**
     * Get the trackings that owns the consolidated.
     */
    public function trackings()
    {
        return $this->hasMany(Tracking::class);
    }

    /**
     * Get the EventsUsers that owns the consolidated.
     */
    public function eventsUsers()
    {
        return $this->hasMany(EventsUsers::class);
    }
}
