<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{

    public function getAllCountries()
    {
      return response()->json(Country::all());
    }

}

