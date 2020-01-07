<?php namespace App\Models;

//use App\Models\Pattern;
use App\Models\RootClass;
use App\Models\RootStatus;

class Root extends BaseModel 
{ 
  protected $with       = ['rootClass','rootStatus']; 
  protected $table      = 'roots';
  protected $hidden     = ['class_id'];
  //protected $hidden     = ['pattern_id', 'class_id'];
  protected $fillable   = ['id','root'];
  //protected $appends    = ['status'];


  public function getStatusAttribute(){
    if($this->rootStatus){
        if($this->rootStatus->status){
            return $this->rootStatus->status;
        }else{
            return null;
        }
    }else{
        return null;
    }
  }


  public function pattern() 
  {
    return $this->belongsTo(Pattern::class, 'pattern_id', 'id');
  }
 

  public function rootClass() 
  {
    return $this->belongsTo(RootClass::class, 'class_id', 'id');
  }


  public function rootStatus()
  {
    return $this->hasOne(RootStatus::class,'root_id','id')->orderBy('created_at','desc');
  }

}
