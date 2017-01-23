<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [

        'client_id', 'name'

    ];


    /**
     * Relationship with Product model
     * @return mixed
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
