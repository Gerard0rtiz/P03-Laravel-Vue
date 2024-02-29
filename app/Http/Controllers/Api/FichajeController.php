<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FichajeController extends Controller
{
    public function index()
    {
        $fichajes = Fichaje::all()->toArray();
        return $fichajes;
    }
}
