<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
   
	 protected $fillable = ['ide','fullname', 'company', 'job', 'email', 'web', 'phone1','phone2','comments', 'address','referred','referred_others','image','status','income','debts','debts_amount','potencial','prima','formalization_date','reservation_date','option_date','expedient_date','credit','avaluo_date','documents','documents_text','fiador','fiador_text','project','bank','bank2','email2','cita'];

 	public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search)
        {
            $query->where('fullname', 'like', '%' . $search . '%')
                  ->orWhere('job', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone1', 'like', '%' . $search . '%')
                  //->orWhere('phone2', 'like', '%' . $search . '%')
                  ->orWhere('comments', 'like', '%' . $search . '%');
                  
        });
    }

    public function setIncomeAttribute($income)
    {
        $this->attributes['income'] = (number($income) == "") ? 0 : number($income);
    }
    public function setDebtsAmountAttribute($debts_amount)
    {
        $this->attributes['debts_amount'] = (number($debts_amount) == "") ? 0 : number($debts_amount);
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
        if (is_string($sellers)) {
            return $this->sellers()->sync([$sellers]);
        }

        return $this->sellers()->sync($sellers);
        
    }

     /**
     * Relationship with the Task Model
     * @return [type] [description]
     */
    public function abonos()
    {
         return $this->hasMany(Abono::class)->latest();
    }

    /**
     * Relationship with the Task Model
     * @return [type] [description]
     */
    public function tasks()
    {
         return $this->hasMany(Task::class)->latest();
    }

    /**
     * Relationship with the Property Model
     * @return [type] [description]
     */
       public function properties()
       {
            return $this->belongsToMany(Property::class);
       }
    
    /**
     * Assign the given client to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignProperty($properties)
    {
        return $this->properties()->sync($properties);
        
    }

     /**
     * Relationship with the Property Model
     * @return [type] [description]
     */
       public function requirements()
       {
            return $this->belongsToMany(Requirement::class);
       }

       /**
     * Assign the given client to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignRequirement($requirements)
    {
        return $this->requirements()->sync($requirements);
        
    }

     public function proyecto()
    {
        return $this->HasOne(Project::class, 'id','project');
    }

    public function estados()
    {
        return $this->HasMany(Comment::class)->latest();
    }

    /**
     * Relationship with the Task Model
     * @return [type] [description]
     */
    public function files()
    {
         return $this->hasMany(File::class);
    }

     public function banco()
    {
        return $this->HasOne(Bank::class, 'id','bank');
    }
     public function banco2()
    {
        return $this->HasOne(Bank::class, 'id','bank2');
    }

    public function getBankName()
    {
        return $this->bank != 0 ? Bank::find($this->bank)->name : '';
    }
    public function getBank2Name()
    {
        return $this->bank2 != 0 ? Bank::find($this->bank2)->name : '';
    }

}
