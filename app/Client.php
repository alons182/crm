<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
   
	 protected $fillable = ['fullname', 'company', 'job', 'email', 'web', 'phone1','phone2','phone3','phone4', 'address','image'];

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
        return $this->sellers()->sync($sellers);
        
    }


}
