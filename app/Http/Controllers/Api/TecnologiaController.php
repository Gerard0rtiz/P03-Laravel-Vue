<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tecnologia;


class TecnologiaController extends Controller
{
    public function index()
    {
        $tecnologias = Tecnologia::all()->toArray();
        return $tecnologias;
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

    //para los usuarios asignados en la tecnologia
    public function eliminarUsuario($idTecnologia, $idUser)
    {
        $tecnologia = Tecnologia::find($idTecnologia);

        if (!$tecnologia) {
            return response()->json(['success' => false, 'message' => 'Tecnologia no encontrada'], 404);
        }

        $tecnologia->users()->detach($idUser);

        // Después de eliminar el usuario, devolver la lista actualizada de usuarios asignados a la tecnologia
        $usuariosAsignados = $tecnologia->users()->get();
        return response()->json(['success' => true, 'data' => $usuariosAsignados]);
    }

    public function asignarUsuario($idTecnologia, $idUser, $nivel){
        $tecnologia = Tecnologia::find($idTecnologia);
    
        if (!$tecnologia) {
            return response()->json(['success' => false, 'message' => 'Tecnologia no encontrada'], 404);
        }
    
        // Verificar si el usuario ya está asignado a esta habilidad
        $existingUser = $tecnologia->users()->where('idUser', $idUser)->exists();
        if ($existingUser) {
            return response()->json(['success' => false, 'message' => 'El usuario ya está asignado a esta habilidad'], 400);
        }
    
        $tecnologia->users()->attach($idUser, ['nivel' => $nivel]);
    
        // Después de asignar el usuario, devolver la lista actualizada de usuarios asignados a la tecnologia
        $usuariosAsignados = $tecnologia->users()->get();
        return response()->json(['success' => true, 'data' => $usuariosAsignados]);
    }

    public function getUsersByTecnologiaId($tecnologiaId){
        $tecnologia = Tecnologia::with('users')->findOrFail($tecnologiaId);

        return $tecnologia;
    }
}
