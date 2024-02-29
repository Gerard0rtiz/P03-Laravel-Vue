<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImputacionController extends Controller
{
    public function index()
    {
        $imputaciones = Imputacion::all()->toArray();
        return $imputaciones;
    }
}
