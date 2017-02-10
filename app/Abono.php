<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    protected $fillable = ['client_id','amount','description'];

    public function setAmountAttribute($amount)
    {
        $this->attributes['amount'] = (number($amount) == "") ? 0 : number($amount);
    }
    /**
     * Relationship with the Task Model
     * @return [type] [description]
     */
    public function client()
    {
         return $this->belongsTo(Client::class);
    }
}
