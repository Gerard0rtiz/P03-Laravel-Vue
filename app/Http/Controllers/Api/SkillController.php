<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    public function index()
    {
        $fichajes = Skill::all()->toArray();
        return $fichajes;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'nivel' => 'required'
        ]);
        $skill = $request->all();
        $createdSkill = Skill::create($skill);
        return response()->json(['success' => true, 'data' => $createdSkill]);
    }

    public function update($id, Request $request)
    {
        $Skill = Skill::find($id);
        $request->validate([
            'nombre' => 'required',
            'nivel' => 'required'
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

    
}
