<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tecnologia;


class TecnologiaController extends Controller
{
    public function index()
    {
        $fichajes = Tecnologia::all()->toArray();
        return $fichajes;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);
        $tecnologia = $request->all();
        $createdTecnologia = Tecnologia::create($tecnologia);
        return response()->json(['success' => true, 'data' => $createdTecnologia]);
    }

    public function update($id, Request $request)
    {
        $Tecnologia = Tecnologia::find($id);
        $request->validate([
            'nombre' => 'required'
        ]);
        $dataToUpdate = $request->all();
        $Tecnologia->update($dataToUpdate);
        return response()->json(['success' => true, 'data' => $Tecnologia]);
    }

    public function destroy($id){
        $tecnologia = Tecnologia::find($id);
        $tecnologia->delete();
        return response()->json(['success' => true, 'data' => 'Tecnologia eliminada correctamente']);
    }

    public function show($id){
        return Tecnologia::find($id);
    }

    
}
