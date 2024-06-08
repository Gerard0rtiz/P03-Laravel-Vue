<?php
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\ProyectoController;
use App\Http\Controllers\Api\ImputacionController;
use App\Http\Controllers\Api\FichajeController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\TecnologiaController;

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ForgotPasswordController;

Route::post('forget-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forget.password.post');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');
Route::get('tasks',[TaskController::class,'index']);
Route::post('tasks/',[TaskController::class,'store']);
Route::put('tasks/update/{id}',[TaskController::class,'update']);
Route::delete('tasks/{id}',[TaskController::class,'destroy']);

//Rutas de SkillController
Route::get('skills',[SkillController::class,'index']);
Route::post('skills/',[SkillController::class,'store']);
Route::get('skills/{id}',[SkillController::class,'show']);
Route::put('skills/update/{id}',[SkillController::class,'update']);
Route::delete('skills/{id}',[SkillController::class,'destroy']);
Route::delete('/skills/{idSkill}/usuarios/{idUser}', [SkillController::class, 'eliminarUsuario']);
Route::post('/skills/{idSkill}/usuarios/{idUser}/{nivel}', [SkillController::class, 'asignarUsuario']);
Route::get('skills/{id}/usuarios', [SkillController::class, 'getUsersBySkillId']);

//Rutas de TecnologiaController
Route::get('tecnologias',[TecnologiaController::class,'index']);
Route::post('tecnologias/',[TecnologiaController::class,'store']);
Route::get('tecnologias/{id}',[TecnologiaController::class,'show']);
Route::put('tecnologias/update/{id}',[TecnologiaController::class,'update']);
Route::delete('tecnologias/{id}',[TecnologiaController::class,'destroy']);
Route::delete('/tecnologias/{idTecnolgia}/usuarios/{idUser}', [TecnologiaController::class, 'eliminarUsuario']);
Route::post('/tecnologias/{idTecnologia}/usuarios/{idUser}/{nivel}', [TecnologiaController::class, 'asignarUsuario']);
Route::get('tecnologias/{id}/usuarios', [TecnologiaController::class, 'getUsersByTecnologiaId']);

//Rutas de ProyectoController:
Route::get('proyectos',[ProyectoController::class,'index']);
Route::get('proyectos/{id}',[ProyectoController::class,'show']);
Route::post('proyectos/',[ProyectoController::class,'store']);
Route::put('proyectos/update/{id}',[ProyectoController::class,'update']);
Route::delete('proyectos/{id}',[ProyectoController::class,'destroy']);
Route::delete('/proyectos/{idProyecto}/usuarios/{idUser}', [ProyectoController::class, 'eliminarUsuario']);
Route::post('/proyectos/{idProyecto}/usuarios/{idUser}', [ProyectoController::class, 'asignarUsuario']);
Route::get('proyectos/{id}/usuarios', [ProyectoController::class, 'getUsersByProyectoId']);
Route::get('Proyecto',[ProyectoController::class,'index']);

//Rutas de ImputacionController:
Route::get('imputaciones',[ImputacionController::class,'index']);
Route::get('imputaciones/{id}',[ImputacionController::class,'show']);
Route::post('imputaciones/',[ImputacionController::class,'store']);
Route::put('imputaciones/update/{id}',[ImputacionController::class,'update']);
Route::delete('imputaciones/{id}',[ImputacionController::class,'destroy']);

//Rutas de FichajeController:
Route::get('fichajes',[FichajeController::class,'index']);
Route::get('fichajes/{id}',[FichajeController::class,'show']);
Route::post('fichajes/',[FichajeController::class,'store']);
Route::put('fichajes/update/{id}',[FichajeController::class,'update']);
Route::delete('fichajes/{id}',[FichajeController::class,'destroy']);

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::apiResource('users', UserController::class);
    Route::apiResource('posts', PostController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('roles', RoleController::class);
    //Route::apiResource('exercises', ExerciseController::class);
    Route::post('exercises/', [ExerciseController::class,'store']); //Guardar
    Route::get('exercises', [ExerciseController::class,'index']); //Listar
    Route::get('exercises/{exercise}', [ExerciseController::class,'show']); //Mostrar
    Route::post('exercises/update/{id}', [ExerciseController::class,'update']); //Editar

    Route::get('role-list', [RoleController::class, 'getList']);
    Route::get('role-permissions/{id}', [PermissionController::class, 'getRolePermissions']);
    Route::put('/role-permissions', [PermissionController::class, 'updateRolePermissions']);
    Route::apiResource('permissions', PermissionController::class);
    Route::get('category-list', [CategoryController::class, 'getList']);
    Route::get('/user', [ProfileController::class, 'user']);
    Route::put('/user', [ProfileController::class, 'update']);
   
    Route::get('abilities', function(Request $request) {
        return $request->user()->roles()->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('name')
            ->unique()
            ->values()
            ->toArray();
    });
});


Route::get('category-list', [CategoryController::class, 'getList']);
Route::get('get-posts', [PostController::class, 'getPosts']);
Route::get('get-category-posts/{id}', [PostController::class, 'getCategoryByPosts']);
Route::get('get-post/{id}', [PostController::class, 'getPost']);
?>