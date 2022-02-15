<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\katalog;

class KatalogController extends Controller
{
    public function home ()
    {
        $katalog = katalog::all();

        return response()->json($katalog,200);
    }
}
