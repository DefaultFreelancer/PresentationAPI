<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pattern;

class RootPatternController extends Controller
{

    public function getAllPatternes()
    {
      return response()->json(Pattern::all());
    }

    public function getOnePattern($id)
    {
      $root = Pattern::findOrFail($id);
      return response()->json($root);
    }

}

