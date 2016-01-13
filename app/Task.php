<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['client_id','title', 'description','status'];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }
   
}
