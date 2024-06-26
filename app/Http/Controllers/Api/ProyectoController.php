<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proyecto;

class ProyectoController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario tiene el rol de administrador
        if ($user->hasRole('admin') || $user->hasRole('jefe')) {
            // Si es administrador, obtener todos los proyectos
            $proyectos = Proyecto::all();
        } else {
            // Si no es administrador, obtener los proyectos asociados al usuario actual
            $proyectos = $user->proyectos;
        }

        return response()->json($proyectos);
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

    public function destroy($id)
    {
        $Proyecto = Proyecto::find($id);
        $Proyecto->delete();
        return response()->json(['success' => true, 'data' => 'Proyecto eliminado correctamente']);
    }

    public function show($id)
    {
        return Proyecto::find($id);
    }

    //para los usuarios asignados en el proyecto
    public function eliminarUsuario($idProyecto, $idUser)
    {
        $proyecto = Proyecto::find($idProyecto);

        if (!$proyecto) {
            return response()->json(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
        }

        $proyecto->users()->detach($idUser);

        // Después de eliminar el usuario, devolver la lista actualizada de usuarios asignados al proyecto
        $usuariosAsignados = $proyecto->users()->get();
        return response()->json(['success' => true, 'data' => $usuariosAsignados]);
    }

    public function asignarUsuario($idProyecto, $idUser)
    {
        $proyecto = Proyecto::find($idProyecto);

        if (!$proyecto) {
            return response()->json(['success' => false, 'message' => 'Proyecto no encontrado'], 404);
        }

        $proyecto->users()->attach($idUser);

        // Después de asignar el usuario, devolver la lista actualizada de usuarios asignados al proyecto
        $usuariosAsignados = $proyecto->users()->get();
        return response()->json(['success' => true, 'data' => $usuariosAsignados]);
    }

    public function getUsersByProyectoId($proyectoId)
    {
        $proyecto = Proyecto::with('users')->findOrFail($proyectoId);

        return $proyecto;
    }

    //filtrado de proyectos a partir de eloquent
    public function filtrarProyectos(Request $request)
    {
        $query = Proyecto::query();

        if ($request->has('filtro')) {
            $filtro = $request->input('filtro');
            $query->where('titulo', 'like', "%$filtro%");
        }

        $proyectos = $query->get();

        return $proyectos;
    }

}
