<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Usuario\UsuarioController;

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
const LISTADO = "listado";// ruta-vista con el listado del modulo
const NUEVO = "new";// ruta-vista con frm para nuevo registro, en ingles por el nuevo/nueva
const GUARDAR="guardar";//ruta que ejeuta funcion que guarda frm de /new
const ACTUALIZAR="actualizar";//ruta que ejecuta funcion que guarda frm de ver
const INACTIVO="eliminar";//ruta que ejecuta funcion que inactiva registro
const GET_IMAGEN="image/dropzone/get";// para traer el file al dropzone
const ELIMINAR_IMAGEN="image/dropzone/delete";
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
    Route::prefix('usuario')->as("usuario/")->group(function () {
        ///Route::get('/elegir_sucursal', [LoginController::class,"elegir_sucursal"]);
        Route::get(LISTADO, [UsuarioController::class,"listado"])->name('index');
        Route::get(NUEVO, [UsuarioController::class, "nuevo"])->name('create');
        Route::post(GUARDAR, [UsuarioController::class,"guardar"])->name('guardar');
        Route::get("/ver/{id?}",[UsuarioController::class,"ver"])->name("ver");
        Route::post(ACTUALIZAR,[UsuarioController::class , "editar"])->name("editar");
        ///editar a inactivo el registro seleccionado (del listado)
        Route::post(INACTIVO, [UsuarioController::class, "eliminar"])->name("eliminar");
        Route::post("/modal_ver",[UsuarioController::class, "modal_ver"])->name("modal_ver");//modal ver
        ////////////////////////// Todo lo relacionado con el Perfil /////////////////////////////
        Route::get("/perfil",[UsuarioController::class,"perfil"])->name("perfil");
        Route::post(GET_IMAGEN, [UsuarioController::class,"getImageDropzone"])->name('getImageDropzone');
        Route::post(ELIMINAR_IMAGEN, [UsuarioController::class,"deleteImageDropzone"])->name('deleteImageDropzone');
    });
    Route::prefix('sucursal')->as("sucursal/")->namespace('App\Http\Controllers\Configuraciones')->group(function () {
        Route::get(LISTADO, 'SucursalController@listado')->name('index');
        Route::get(NUEVO, 'SucursalController@nueva')->name('nueva');
        Route::post(GUARDAR, 'SucursalController@guardar')->name('guardar');
        Route::get("/ver/{id?}","SucursalController@ver")->name("ver");
        Route::post(ACTUALIZAR,"SucursalController@editar")->name("editar");
        Route::post(INACTIVO,"SucursalController@eliminar")->name("eliminar");
        ///PARA EL DROPZONE/////
        Route::post(GET_IMAGEN, 'SucursalController@getImageDropzone')->name('getImageDropzone');
        Route::post(ELIMINAR_IMAGEN, 'SucursalController@deleteImageDropzone')->name('deleteImageDropzone');
        ///PARA EL DROPZONE/////
    });
    Route::prefix('menu')->as("menu/")->namespace('App\Http\Controllers\Configuraciones')->group(function () {
        Route::get(LISTADO, 'MenuController@listado')->name('listado');
        Route::get(NUEVO, 'MenuController@nuevo')->name('nuevo');
        Route::post(GUARDAR, 'MenuController@guardar')->name('guardar');
        Route::get("/ver/{id?}","MenuController@ver")->name("ver");
        Route::post(ACTUALIZAR,"MenuController@editar")->name("editar");
        Route::post(INACTIVO,"MenuController@eliminar")->name("eliminar");
    });
    Route::prefix('rol')->as("rol/")->namespace('App\Http\Controllers\Configuraciones')->group(function () {
        Route::get(LISTADO, 'RolController@listado')->name('listado');
        Route::get(NUEVO, 'RolController@nuevo')->name('nuevo');
        Route::post(GUARDAR, 'RolController@guardar')->name('guardar');
        Route::get("/ver/{id?}","RolController@ver")->name("ver");
        Route::post(ACTUALIZAR,"RolController@editar")->name("editar");
        Route::post(INACTIVO,"RolController@eliminar")->name("eliminar");

        Route::get("/permisos/","RolController@permisos")->name("permisos");
    });
    Route::prefix('permiso')->as("permiso/")->namespace('App\Http\Controllers\Configuraciones')->group(function () {
        Route::get(LISTADO, 'PermisoController@listado')->name('listado');
        Route::get(NUEVO, 'PermisoController@nuevo')->name('nuevo');
        Route::post(GUARDAR, 'PermisoController@guardar')->name('guardar');
        Route::get("/ver/{id?}","PermisoController@ver")->name("ver");
        Route::post(ACTUALIZAR,"PermisoController@editar")->name("editar");
        Route::post(INACTIVO,"PermisoController@eliminar")->name("eliminar");
    });

});

