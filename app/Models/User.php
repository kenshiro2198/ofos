<?php

namespace App\Models;

use App\Custom\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Str;

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
        'password', 'remember_token',
    ];
    protected $appends = ['fullname'];

    /**
     * Roll API Key
     */
    public function rollApiKey()
    {
        do {
            $this->api_token = Str::random(60);
        } while ($this->where('api_token', $this->api_token)->exists());
        $this->save();
    }

    /**
     * Roll CSRF Key
     */
    public function rollCsrfKey()
    {
        do {
            $this->csrf_token = Str::random(60);
        } while ($this->where('csrf_token', $this->csrf_token)->exists());
        $this->save();
        return $this->csrf_token;
    }
    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
