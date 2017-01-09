<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $fillable = ['name','bank_id'];
    
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
	    public function bank()
	    {
	         return $this->belongsTo(Bank::class);
	    }


    /**
     * Relationship with the Client Model 
     * @return [type] [description]
     */
       public function clients()
       {
            return $this->belongsToMany(Client::class);
       }
}
