<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RootClass;

class RootClassController extends Controller
{

    public function getAllRootClasses()
    {
      return response()->json(RootClass::all());
    }

    public function getOneRootClass($id)
    {
      $root = RootClass::findOrFail($id);
      return response()->json($root);
    }

}

