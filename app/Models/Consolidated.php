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
        'number', 'user_id', 'cstate_id', 'close_at', 'created_at'
    ];

    protected $dates = ['close_at'];

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
     * Get the cstate that owns the consolidated.
     */
    public function cstate()
    {
        return $this->belongsTo(\skyimport\Models\Cstate::class);
    }
}
