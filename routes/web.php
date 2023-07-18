<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ExperienciaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Rutas para el inicio de sesión
Route::post('/inicia_sesion', [LoginController::class, 'login'])->name('inicia_sesion');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/inicio', function () {return view('inicio');})->name('inicio')->middleware('auth');
Route::get('/', function () {return view('login');})->name('loginSistema');

// Rutas Usuario
Route::get('/usuarios/index', [UsuarioController::class, 'index'])->middleware('auth');
Route::get('/get_usuarios', [UsuarioController::class, 'getUsuarios'])->middleware('auth');
Route::post('/set_usuario', [UsuarioController::class, 'setUsuario'])->middleware('auth');
Route::post('/usuario/eliminar', [UsuarioController::class, 'eliminarUsuario'])->middleware('auth');


// Rutas Roles
Route::get('/roles/index', [RolController::class, 'index'])->middleware('auth');
Route::get('/rol/listar', [RolController::class, 'getRoles'])->middleware('auth');
Route::post('/rol/guardar', [RolController::class, 'setRol'])->middleware('auth');
Route::get('/get_roles', [RolController::class, 'getRoles'])->middleware('auth');
Route::post('/rol/eliminar', [RolController::class, 'eliminar'])->middleware('auth');

// Docente
Route::get('/docente', [DocenteController::class, 'index'])->middleware('auth');
Route::post('/docente/guardar', [DocenteController::class, 'guardar'])->middleware('auth');
Route::get('/docente/listar', [DocenteController::class, 'listar'])->middleware('auth');
Route::post('/docente/eliminar', [DocenteController::class, 'eliminar'])->middleware('auth');


// Especialidad
Route::get('/especialidad', [EspecialidadController::class, 'index'])->middleware('auth');
Route::post('/especialidad/guardar', [EspecialidadController::class, 'guardar'])->middleware('auth');
Route::get('/especialidad/listar', [EspecialidadController::class, 'listar'])->middleware('auth');
Route::post('/especialidad/eliminar', [EspecialidadController::class, 'eliminar'])->middleware('auth');
Route::get('/especialidad/listar_docentes', [EspecialidadController::class, 'listarDocentes'])->middleware('auth');

// Curso
Route::get('/curso', [CursoController::class, 'index'])->middleware('auth');
Route::post('/curso/guardar', [CursoController::class, 'guardar'])->middleware('auth');
Route::get('/curso/listar', [CursoController::class, 'listar'])->middleware('auth');
Route::post('/curso/eliminar', [CursoController::class, 'eliminar'])->middleware('auth');
Route::get('/curso/listar_docentes', [CursoController::class, 'listarDocentes'])->middleware('auth');

// Experiencia
Route::get('/experiencia', [ExperienciaController::class, 'index'])->middleware('auth');
Route::post('/experiencia/guardar', [ExperienciaController::class, 'guardar'])->middleware('auth');
Route::get('/experiencia/listar', [ExperienciaController::class, 'listar'])->middleware('auth');
Route::post('/experiencia/eliminar', [ExperienciaController::class, 'eliminar'])->middleware('auth');
Route::get('/experiencia/listar_docentes', [ExperienciaController::class, 'listarDocentes'])->middleware('auth');

Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
