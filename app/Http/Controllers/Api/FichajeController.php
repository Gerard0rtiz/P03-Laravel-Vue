<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fichaje;

class FichajeController extends Controller
{
    public function index()
    {
        $fichajes = Fichaje::all()->toArray();
        return $fichajes;
    }

    public function store(Request $request)
    {
        $request->validate([
            'idUser' => 'required',
            'fechaFichaje' => 'required',
            'horaEntrada' => 'required',
            'horaSalida' => 'required'
        ]);
        $fichaje = $request->all();
        $createdFichaje = Fichaje::create($fichaje);
        return response()->json(['success' => true, 'data' => $createdFichaje]);
    }

    public function update($id, Request $request)
    {
        $Fichaje = Fichaje::find($id);
        $request->validate([
            'idUser' => 'required',
            'fechaFichaje' => 'required',
            'horaEntrada' => 'required',
            'horaSalida' => 'required'
        ]);
        $dataToUpdate = $request->all();
        $Fichaje->update($dataToUpdate);
        return response()->json(['success' => true, 'data' => $Fichaje]);
    }

    public function destroy($id){
        $Fichaje = Fichaje::find($id);
        $Fichaje->delete();
        return response()->json(['success' => true, 'data' => 'Fichaje eliminado correctamente']);
    }

    public function show($id){
        return Fichaje::find($id);
    }    
}
