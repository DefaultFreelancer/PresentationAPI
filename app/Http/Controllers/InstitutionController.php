<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institution;

class InstitutionController extends Controller
{

    public function getAllInstitutions()
    {
      return response()->json(Institution::all());
    }

}

