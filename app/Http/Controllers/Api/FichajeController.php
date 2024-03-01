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

    public function store(Request $request)
    {
        $request->validate([
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
}
