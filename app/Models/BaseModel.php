<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model {

  protected $casts = [
    'created_at' => 'datetime:c',
    'updated_at' => 'datetime:c',
  ];
  
  public function toArray()
  {
    $data = array_merge($this->attributesToArray(), $this->relationsToArray());
    return $this->replaceKeys($data);
  }
  
  function replaceKeys(array $input) {
    
    $return = array();
    foreach ($input as $key => $value) {
      
      $key = Str::camel($key);
      
      if (is_array($value)){
        $value = $this->replaceKeys($value); 
      }

      $return[$key] = $value;
    }
    return $return;
  }
}


