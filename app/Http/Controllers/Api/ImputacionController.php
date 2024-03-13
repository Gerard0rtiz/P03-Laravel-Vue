<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Imputacion;

class ImputacionController extends Controller
   {
      public function index()
      {
          $imputaciones = Imputacion::all()->toArray();
          return $imputaciones;
      }

      public function show($id)
      {
        return Imputacion::find($id);
      }
  
      public function store(Request $request)
      {
          $request->validate([
              'idUser' => 'required',
              'idProyecto' => 'required',
              'fechaImputacion' => 'required',
              'horasRealizadas' => 'required',
              'descripcion' => 'required'
          ]);

          $imputacion = $request->all();
          $createdImputacion = Imputacion::create($imputacion);
          return response()->json(['success' => true, 'data' => $createdImputacion]);
      }
  
      public function update($id, Request $request)
      {
          $Imputacion = Imputacion::find($id);
          $request->validate([
              'idUser' => 'required',
              'idProyecto' => 'required',
              'fechaImputacion' => 'required',
              'horasRealizadas' => 'required',
              'descripcion' => 'required'
          ]);
          $dataToUpdate = $request->all();
          $Imputacion->update($dataToUpdate);
          return response()->json(['success' => true, 'data' => $Imputacion]);
      }
  
      public function destroy($id){
          $Imputacion = Imputacion::find($id);
          $Imputacion->delete();
          return response()->json(['success' => true, 'data' => 'Imputacion eliminada correctamente']);
      }
}
