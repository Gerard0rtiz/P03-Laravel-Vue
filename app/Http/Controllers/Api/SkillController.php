<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::all()->toArray();
        return $skills;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);
        $skill = $request->all();
        $createdSkill = Skill::create($skill);
        return response()->json(['success' => true, 'data' => $createdSkill]);
    }

    public function update($id, Request $request)
    {
        $Skill = Skill::find($id);
        $request->validate([
            'nombre' => 'required'
        ]);
        $dataToUpdate = $request->all();
        $Skill->update($dataToUpdate);
        return response()->json(['success' => true, 'data' => $Skill]);
    }

    public function destroy($id){
        $skill = Skill::find($id);
        $skill->delete();
        return response()->json(['success' => true, 'data' => 'Skill eliminada correctamente']);
    }

    public function show($id){
        return Skill::find($id);
    }

    //para los usuarios asignados en la skill
    public function eliminarUsuario($idSkill, $idUser)
    {
        $skill = Skill::find($idSkill);

        if (!$skill) {
            return response()->json(['success' => false, 'message' => 'Skill no encontrada'], 404);
        }

        $skill->users()->detach($idUser);

        // Después de eliminar el usuario, devolver la lista actualizada de usuarios asignados a la skill
        $usuariosAsignados = $skill->users()->get();
        return response()->json(['success' => true, 'data' => $usuariosAsignados]);
    }

    public function asignarUsuario($idSkill, $idUser, $nivel){
        $skill = Skill::find($idSkill);
    
        if (!$skill) {
            return response()->json(['success' => false, 'message' => 'Skill no encontrada'], 404);
        }
    
        // Verificar si el usuario ya está asignado a esta habilidad
        $existingUser = $skill->users()->where('idUser', $idUser)->exists();
        if ($existingUser) {
            return response()->json(['success' => false, 'message' => 'El usuario ya está asignado a esta habilidad'], 400);
        }
    
        $skill->users()->attach($idUser, ['nivel' => $nivel]);
    
        // Después de asignar el usuario, devolver la lista actualizada de usuarios asignados a la skill
        $usuariosAsignados = $skill->users()->get();
        return response()->json(['success' => true, 'data' => $usuariosAsignados]);
    }

    public function getUsersBySkillId($skillId){
        $skill = Skill::with('users')->findOrFail($skillId);

        return $skill;
    }
}
