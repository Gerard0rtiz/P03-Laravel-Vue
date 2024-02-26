<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(){
      //  return "Hola";
      $tasks = Task::All()->toArray();
      return $tasks;
    }

    public function store(Request $request){
        $request->validate([
          'name' => 'required|max:5',
          'description' => 'required',
        ]);
        $task = $request->all();
        $tarea = Task::create($task);

        return response()->json(['success' => true, 'data' => $tarea]);


    }
    public function update($id,Request $request){
      $task = Task::find($id);
      $request->validate([
        'name' => 'required|max:5',
        'description' => 'required',
      ]);
      $dataToUpdate = $request->all();
      $task->update($dataToUpdate);
      return response()->json(['success' => true, 'data' => $task]);
    }
    public function destroy($id,Request $request){
      $task = Task::find($id);
      $task->delete();
      return response()->json(['success' => true, 'data' => 'tarea eliminada correctamente']);
    }
    }

