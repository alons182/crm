<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('name', 'like', '%' . $search . '%')
               ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    /**
     * Relationship with the Profile Model
     * @return [type] [description]
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Relationship with the Client Model
     * @return [type] [description]
     */
    public function clients()
    {
         return $this->belongsToMany(Client::class);
    }

    /**
     * Assign the given client to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignClient($clients)
    {
        return $this->clients()->sync($clients);
        
    }

    /**
     * create a profile
     * @param null $profile
     * @return mixed
     */
    public function createProfile($profile = null)
    {
        $profile = ($profile) ? $profile : new Profile();

        return $this->profile()->save($profile);
    }

     /**
     * Relationship with the stat Model
     * @return [type] [description]
     */
    public function stats()
    {
         return $this->HasMany(Stats::class);
    }

     /**
     * Relationship with the Client Model
     * @return [type] [description]
     */
    public function properties()
    {
         return $this->HasMany(Property::class);
    }

     /**
     * verify if the client is asigned.
     *
     * @param  string $role
     * @return mixed
     */
    public function isAsigned($client)
    {
       
        if (is_string($client) || is_numeric($client)) {
            
            $asigned = $this->clients()->find($client);

            return $asigned ? true : false;
        }

        $asigned = $this->clients()->find($client->id);
        
        return $asigned ? true : false;
        
    }

     
}
