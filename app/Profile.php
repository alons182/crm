<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
	protected $fillable = ['fullname', 'phone1','phone2', 'address','image'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
