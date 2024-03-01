<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImputacionController extends Controller
   {
      public function index()
      {
          $imputaciones = Imputacion::all()->toArray();
          return $imputaciones;
      }

      public function show()
      {
       //  $this->authorize('imputacion-edit');
         //if ($imputacion->user_id !== auth()->user()->id && !auth()->user()->hasPermissionTo('imputacion-all')) {
          //   return response()->json(['status' => 405, 'success' => false, 'message' => 'imputacion prueba']);
         //} else {
          //   return new ImputacionResource($imputacion);
         //}
      }
  
      public function store(Request $request)
      {
          $request->validate([
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
          $imputacion = Imputacion::find($id);
          $request->validate([
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
