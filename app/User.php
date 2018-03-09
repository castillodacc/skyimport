<?php

namespace skyimport;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'address', 'address_two', 'city', 'country_id', 'num_id', 'phone', 'rol_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * Avatar del perfil.
     */
    public function pathAvatar($id = null)
    {
        $ext = ['.jpg','.jpeg','.png'];
        foreach ($ext as $e) {
            if ($id) { $file = $id . $e;
            } else {   $file = \Auth::user()->id . $e; }
            if (file_exists(public_path('/storage/app/').$file)) {
                return asset('storage/app/'.$file);
            }
        }
        return '/img/avatar'.rand(1, 5).'.png';
    }

    /**
     * Nombre completo del usuario.
     */
    public function fullName()
    {
        return $this->name . ' ' . $this->last_name . ' Sky';
    }
}
