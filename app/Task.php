<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['client_id','title', 'description','notification_date','notification_time','notification_reminder','notification_choices_time','notification_to','status','notification_reminder_date','notification_reminder_time'];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }
   
}
