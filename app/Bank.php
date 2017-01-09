<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['name'];
    
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
	    public function requirements()
	    {
	         return $this->HasMany(Requirement::class);
	    }
}
