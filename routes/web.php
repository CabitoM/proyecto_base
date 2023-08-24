<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect("/login");
});
Route::get('phpinfo/', function () {
    phpinfo();
});
Route::get('/register', [RegisterController::class,"show"]);
Route::post("/register", [RegisterController::class,"register"])->name("register");

Route::get('/login', [LoginController::class,"show"]);
Route::post("/login", [LoginController::class,"login"])->name("login");
Route::group(['middleware' => ['auth']],function(){
    Route::get('/elegir_sucursal', [LoginController::class,"elegir_sucursal"]);
    Route::post('/elegir_sucursal', [LoginController::class,"seleccionar_sucursal"])->name("elegir_sucursal");
    Route::get('/logout', [LogoutController::class,"logout"])->name("logout");
});
Route::group(['middleware' => ['auth','sucursal']], function() {

    Route::get('/home', [HomeController::class,"index"])->name("home.index");
    Route::prefix('usuario')->as("usuario/")->namespace('App\Http\Controllers\Usuario')->group(function () {
        Route::get('/listado', 'UsuarioController@listado')->name('index');
        Route::get('/nuevo', 'UsuarioController@nuevo')->name('create');///crear nuevo (vista)
        Route::post('/guardar', 'UsuarioController@guardar')->name('guardar');///guardar el nuevo
        Route::get("/ver/{id?}","UsuarioController@ver")->name("ver");///ver el registro
        Route::post("/editar","UsuarioController@editar")->name("editar");///editar el registro mostrado
        Route::post("/eliminar","UsuarioController@eliminar")->name("eliminar");///editar a inactivo el registro seleccionado (del listado)
        Route::post("/modal_ver","UsuarioController@modal_ver")->name("modal_ver");//modal ver
        ////////////////////////// Todo lo relacionado con el Perfil /////////////////////////////
        Route::get("/perfil","UsuarioController@perfil")->name("perfil");/// ver la informacion de el perfil que esta logueado
    });
    Route::prefix('sucursal')->as("sucursal/")->namespace('App\Http\Controllers\Configuraciones')->group(function () {
        Route::get('/listado', 'SucursalController@listado')->name('index');
        Route::get('/nueva', 'SucursalController@nueva')->name('nueva');///crear nuevo (vista)
        Route::post('/guardar', 'SucursalController@guardar')->name('guardar');///guardar el nuevo
        Route::get("/ver/{id?}","SucursalController@ver")->name("ver");///ver el registro
        Route::post("/editar","SucursalController@editar")->name("editar");///editar el registro mostrado
        Route::post("/eliminar","SucursalController@eliminar")->name("eliminar");///editar a inactivo el registro seleccionado (del listado)
        ///PARA EL DROPZONE/////
        Route::post('/image/dropzone/get', 'SucursalController@getImageDropzone')->name('getImageDropzone');
        Route::post('/image/dropzone/delete', 'SucursalController@deleteImageDropzone')->name('deleteImageDropzone');
        ///PARA EL DROPZONE/////
    });
    Route::prefix('menu')->as("menu/")->namespace('App\Http\Controllers\Configuraciones')->group(function () {
        Route::get("/listado", 'MenuController@listado')->name('listado');
        Route::get("/nuevo", 'MenuController@nuevo')->name('nuevo');
        Route::post("/guardar", 'MenuController@guardar')->name('guardar');
        Route::get("/ver/{id?}","MenuController@ver")->name("ver");
        Route::post("/editar","MenuController@editar")->name("editar");
        Route::post("/eliminar","MenuController@eliminar")->name("eliminar");
    });
    Route::prefix('rol')->as("rol/")->namespace('App\Http\Controllers\Configuraciones')->group(function () {
        Route::get("/listado", 'RolController@listado')->name('listado');
        Route::get("/nuevo", 'RolController@nuevo')->name('nuevo');
        Route::post("/guardar", 'RolController@guardar')->name('guardar');
        Route::get("/ver/{id?}","RolController@ver")->name("ver");
        Route::post("/editar","RolController@editar")->name("editar");
        Route::post("/eliminar","RolController@eliminar")->name("eliminar");

        Route::get("/permisos/","RolController@permisos")->name("permisos");
    });
    Route::prefix('permiso')->as("permiso/")->namespace('App\Http\Controllers\Configuraciones')->group(function () {
        Route::get("/listado", 'PermisoController@listado')->name('listado');
        Route::get("/nuevo", 'PermisoController@nuevo')->name('nuevo');
        Route::post("/guardar", 'PermisoController@guardar')->name('guardar');
        Route::get("/ver/{id?}","PermisoController@ver")->name("ver");
        Route::post("/editar","PermisoController@editar")->name("editar");
        Route::post("/eliminar","PermisoController@eliminar")->name("eliminar");
    });

});

