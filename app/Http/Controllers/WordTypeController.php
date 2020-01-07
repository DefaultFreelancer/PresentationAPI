<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WordType;


class WordTypeController extends Controller 
{

  public function getWordTypes(){
  
    return response()->json(WordType::all());

  }
    
}