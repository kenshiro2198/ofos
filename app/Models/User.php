<?php

namespace App\Models;

use App\Custom\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'number', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'csrf_token',
    ];
    /**
     * Roll API Key
     */
    public function rollApiKey()
    {
        do {
            $this->api_token = str_random(60);
        } while ($this->where('api_token', $this->api_token)->exists());
        $this->save();
    }

    /**
     * Roll CSRF Key
     */
    public function rollCsrfKey()
    {
        do {
            $this->csrf_token = str_random(60);
        } while ($this->where('csrf_token', $this->csrf_token)->exists());
        $this->save();
        return $this->csrf_token;
    }
}
