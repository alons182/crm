<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name','province','address','image', 'status'];
    
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    /**
     * Relationship with the Client Model 
     * @return [type] [description]
     */
       /*public function clients()
       {
            return $this->belongsToMany(Client::class);
       }*/

       /**
     * Relationship with the Client Model
     * @return [type] [description]
     */
	    public function properties()
	    {
	         return $this->HasMany(Property::class);
	    }
}
