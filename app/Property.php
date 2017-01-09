<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
	
    protected $fillable = ['name','price', 'province','address','size','construction','rooms','owner','owner_phone1','owner_phone2','owner_email','project','status','image','user_id','project_id','percent','seller_percent','office'];
    
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('province', 'like', '%' . $search . '%');
        });
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
     * Relationship with the Client Model 
     * @return [type] [description]
     */
       public function seller()
       {
            return $this->belongsTo(User::class, 'user_id');
       }

       /**
     * Relationship with the Client Model 
     * @return [type] [description]
     */
       public function project()
       {
            return $this->belongsTo(Project::class, 'project_id');
       }
}
