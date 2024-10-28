<?php

use App\Http\Controllers\api\AlbaranController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\api\ClientController;
use App\Http\Controllers\api\MaterialController;
use App\Http\Controllers\api\Orden_trabajoController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\api\ProveidorController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\api\TaskController;
use App\Http\Controllers\api\ClientControllerController;
use App\Http\Controllers\api\CpMunicipiController;
use App\Http\Controllers\api\IdiomaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\ForgotPasswordController;

Route::post('forget-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forget.password.post');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset');

Route::get('clients', [ClientController::class, 'index']);
Route::get('clients/{client}', [ClientController::class, 'show']);
Route::get('clients/showByNif/{nif}', [ClientController::class, 'showByNif']);
Route::post('clients', [ClientController::class, 'store']);
Route::put('clients/{id}', [ClientController::class, 'update']);
Route::delete('clients/{id}', [ClientController::class, 'destroy']);

Route::get('idiomes', [IdiomaController::class, 'index']);

Route::get('cp_municipis/{codi}',[CpMunicipiController::class,'getCp']);

Route::get('tasks',[TaskController::class,'index']);
Route::post('tasks',[TaskController::class,'store']);
Route::put('tasks/{id}',[TaskController::class,'update']);

Route::get('proveidors',[ProveidorController::class,'index']);
Route::get('proveidors/{proveidor}', [ProveidorController::class, 'show']);
Route::get('proveidors/showByNif/{nif}', [ProveidorController::class, 'showByNif']);
Route::post('proveidors',[ProveidorController::class,'store']);
Route::put('proveidors/{id}',[ProveidorController::class,'update']);
Route::delete('proveidors/{id}',[ProveidorController::class,'destroy']);

Route::get('materials',[MaterialController::class,'index']);
Route::post('materials',[MaterialController::class,'store']);
Route::post('materials/{id}',[MaterialController::class,'update']);
Route::delete('materials/{id}',[MaterialController::class,'destroy']);

Route::get('albarans',[AlbaranController::class,'index']);
Route::post('albarans',[AlbaranController::class,'store']);
Route::put('albarans/{id}',[AlbaranController::class,'update']);
Route::delete('albarans/{id}',[AlbaranController::class,'destroy']);


Route::get('ordenes_trabajo',[Orden_trabajoController::class,'index']);
Route::get('ordenes_trabajo/showById/{id}',[Orden_trabajoController::class,'showById']);
Route::post('ordenes_trabajo',[Orden_trabajoController::class,'store']);
Route::put('ordenes_trabajo/{id}',[Orden_trabajoController::class,'update']);
Route::delete('ordenes_trabajo/{id}',[Orden_trabajoController::class,'destroy']);


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
