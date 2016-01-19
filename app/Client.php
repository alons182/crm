<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
   
	 protected $fillable = ['ide','fullname', 'company', 'job', 'email', 'web', 'phone1','phone2','phone3','phone4', 'address','image'];

 	public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('fullname', 'like', '%' . $search . '%');
                //->orWhere('description', 'like', '%' . $search . '%');
        });
    }


	/**
	 * Relationship with the User Model (Seller)
	 * @return [type] [description]
	 */
   public function sellers()
   {
   	  	return $this->belongsToMany(User::class);
   }

     /**
     * Assign the given client to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignSeller($sellers)
    {
        if (is_string($sellers)) {
            return $this->sellers()->sync([$sellers]);
        }

        return $this->sellers()->sync($sellers);
        
    }

    /**
     * Relationship with the Task Model
     * @return [type] [description]
     */
    public function tasks()
    {
         return $this->hasMany(Task::class)->latest();
    }

    /**
     * Relationship with the Property Model
     * @return [type] [description]
     */
       public function properties()
       {
            return $this->belongsToMany(Property::class);
       }
    
    /**
     * Assign the given client to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignProperty($properties)
    {
        return $this->properties()->sync($properties);
        
    }

}
