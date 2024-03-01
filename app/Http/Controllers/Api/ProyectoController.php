<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
    public function index()
    {
        $proyectos = Proyecto::all()->toArray();
        return $proyectos;
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'idUser' => 'required'
        ]);
        $proyecto = $request->all();
        $createdProyecto = Proyecto::create($proyecto);
        return response()->json(['success' => true, 'data' => $createdProyecto]);
    }

    public function update($id, Request $request)
    {
        $Proyecto = Proyecto::find($id);
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required',
            'idUser' => 'required'
        ]);
        $dataToUpdate = $request->all();
        $Proyecto->update($dataToUpdate);
        return response()->json(['success' => true, 'data' => $Proyecto]);
    }

    public function destroy($id){
        $Proyecto = Proyecto::find($id);
        $Proyecto->delete();
        return response()->json(['success' => true, 'data' => 'Tarea eliminada correctamente']);
    }
}
