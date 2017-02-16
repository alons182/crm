<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body','client_id','user_id'];
    
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('body', 'like', '%' . $search . '%');
        });
    }

     public function client()
     {
        return $this->belongsTo(Client::class);
     }
     public function user()
     {
        return $this->belongsTo(User::class);
     }
}
