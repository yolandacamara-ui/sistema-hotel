<?php

use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\CategoriaHabitacionController;
use App\Http\Controllers\CategoriaServiciosController;
use App\Http\Controllers\ServiciosController;

use App\Http\Controllers\EdadController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Tipo_JugadorController;
use App\Http\Controllers\JugadorController;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonstruoController;
use App\Http\Controllers\PersonajesController;
use App\Http\Controllers\DbUpController;
use App\Http\Controllers\OcupacionController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\DashBoardController;
use App\Models\Jugador;
use App\Models\Monstruo;


Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login/iniciar', [LoginController::class, 'iniciar_sesion']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/sign_up', [JugadorController::class, 'signup']);
Route::post('/crear_cuenta', [JugadorController::class, 'crear_cuenta']);















Route::group(['middleware'=> 'auth'], function (){
//listado de registros
Route::get('/jugador', [JugadorController::class, 'index'])->name('index_jugador'); //le da un nombre a la ruta
//presentar un formulario de captura de datos
Route::get('/jugador/formulario/{id?}', [JugadorController::class, 'formulario']);

Route::post('/jugador/crear_cuenta', [JugadorController::class, 'crear_cuenta']);


Route::get('/jugador/foto/{archivo}', [JugadorController::class, 'mostrar_foto']);

//proceso para la escritura la tabla (insertar, editar, eliminar)
//se va a enviar datos desde un formulario
Route::post('/jugador/save', [JugadorController::class, 'save']);







//listado de registros
Route::get('/tipo_jugador', [Tipo_JugadorController::class, 'index'])->name('index_tipo_jugador'); //le da un nombre a la ruta

//presentar un formulario de captura de datos
Route::get('/tipo_jugador/formulario/{id?}', [Tipo_JugadorController::class, 'formulario']);

//proceso para la escritura la tabla (insertar, eduitar, eliminar)
//se va a enviar datos desde un formulario
Route::post('/tipo_jugador/save', [Tipo_JugadorController::class, 'save']);





//rutas del usuario 
Route::get('/usuario', [UsuarioController::class, 'index'])->name('index_usuario'); //le da un nombre a la ruta

//presentar un formulario de captura de datos
Route::get('/usuario/formulario/{id?}', [UsuarioController::class, 'formulario']);

//proceso para la escritura la tabla (insertar, eduitar, eliminar)
//se va a enviar datos desde un formulario
Route::post('/usuario/save', [UsuarioController::class, 'save']);




//codigo para el login
//Route::get('/login', [LoginController::class, 'login'])->name('login');
// Route::post('/login/iniciar', [LoginController::class, 'iniciar_sesion']);
// Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
//Route::get('/home/jugador', [JugadorController::class, 'home']);
//Route::get('/home/jugador', [JugadorController::class, 'index']);





//rutas del rol
Route::get('/rol', [RolesController::class, 'index'])->name('index_rol'); //le da un nombre a la ruta

//presentar un formulario de captura de datos
Route::get('/rol/formulario/{id?}', [RolesController::class, 'formulario']);

//proceso para la escritura la tabla (insertar, eduitar, eliminar)
//se va a enviar datos desde un formulario
Route::post('/rol/save', [RolesController::class, 'save']);




//rutas de edad
Route::get('/edad', [EdadController::class, 'index'])->name('index_edad'); //le da un nombre a la ruta
//presentar un formulario de captura de datos
Route::get('/edad/formulario/{id?}', [EdadController::class, 'formulario']);
//proceso para la escritura la tabla (insertar, eduitar, eliminar)
//se va a enviar datos desde un formulario
Route::post('/edad/save', [EdadController::class, 'save']);




Route::get('/monstruo', [MonstruoController::class, 'index'])->name('index_monstruo'); //le da un nombre a la ruta
Route::get('/monstruo/formulario/{id?}', [MonstruoController::class, 'formulario']);
Route::post('/monstruo/save', [MonstruoController::class, 'save']);
Route::get('/monstruo/foto/{archivo}', [MonstruoController::class, 'mostrar_foto']);


Route::get('/item', [ItemController::class, 'index'])->name('index_item'); //le da un nombre a la ruta
Route::get('/item/formulario/{id?}', [ItemController::class, 'formulario']);
Route::post('/item/save', [ItemController::class, 'save']);
Route::get('/item/foto/{archivo}', [ItemController::class, 'mostrar_foto']);


Route::get('/personaje', [PersonajesController::class, 'index'])->name('index_personaje'); //le da un nombre a la ruta
Route::get('/personaje/formulario/{id?}', [PersonajesController::class, 'formulario']);
Route::post('/personaje/save', [PersonajesController::class, 'save']);
Route::get('/personaje/foto/{archivo}', [PersonajesController::class, 'mostrar_foto']);





//rutas para el catalogo partidas
Route::get('/partida', [PartidaController::class, 'index'])->name('index_partida'); //le da un nombre a la ruta

//presentar un formulario de captura de datos
Route::get('/partida/formulario/{id?}', [PartidaController::class, 'formulario']); //el signo de ? significa que ese parametro es opcional que se puede entrar a la ruta sin necesidad de tener un id
Route::get('/partida/formulario_unir', [PartidaController::class, 'formulario_unir']); //el signo de ? significa que ese parametro es opcional que se puede entrar a la ruta sin necesidad de tener un id
Route::post('/partida/unir', [PartidaController::class, 'unir_partida']); //el signo de ? significa que ese parametro es opcional que se puede entrar a la ruta sin necesidad de tener un id

//proceso para la escritura la tabla (insertar, eduitar, eliminar)
//se va a enviar datos desde un formulario
Route::post('/partida/crear_partida', [PartidaController::class, 'crear_partida']);
Route::post('/partida/detalle', [PartidaController::class, 'detalle_partida']);
Route::post('/partida/iniciar', [PartidaController::class, 'iniciar_partida']);
Route::post('/partida/turno/iniciar', [PartidaController::class, 'iniciar_turno']);
Route::post('/partida/turno/iniciar_nivel', [PartidaController::class, 'iniciar_turno_nivel']);
Route::post('/partida/turno/atacar_monstruo', [PartidaController::class, 'atacar']);
Route::post('/partida/turno/ataque_monstruo', [PartidaController::class, 'ataque_monstruo']);

Route::get('/jugador/profile', [JugadorController::class, 'profile'])->name('profile_jugador');

//Aqui comienzan las rutas del proyecto integrador (Hotel)

// Habitación

Route::get('habitacion', [HabitacionController::class, 'index'])->name('index_habitacion');
Route::get('habitacion/formulario/{id?}', [HabitacionController::class, 'formulario']);
Route::post('habitacion/save', [HabitacionController::class, 'save']);
Route::get('habitacion/foto/{archivo}', [HabitacionController::class, 'mostrar_foto']);

// Categoría Habitación
Route::get('categoria_habitacion', [CategoriaHabitacionController::class,'index'])->name('index_categoria_habitacion');
Route::get('categoria_habitacion/formulario/{id?}', [CategoriaHabitacionController::class,'formulario']);
Route::post('categoria_habitacion/save', [CategoriaHabitacionController::class,'save']);

// Categoria Servicios

Route::get('categoria_servicios', [CategoriaServiciosController::class,'index'])->name('index_categoria_servicios');
Route::get('categoria_servicios/formulario/{id?}', [CategoriaServiciosController::class,'formulario']);
Route::post('categoria_servicios/save', [CategoriaServiciosController::class,'save']);

// Servicios

Route::get('servicios', [ServiciosController::class,'index'])->name('index_servicios');
Route::get('servicios/formulario/{id?}', [ServiciosController::class,'formulario']);
Route::post('servicios/save', [ServiciosController::class,'save']);


Route::get('/', [HotelController::class, 'index'])
    ->name('inicio');

Route::get('/productos', [HotelController::class, 'habitaciones'])
    ->name('productos');

    Route::get('/dbup/cliente', [DbUpController::class, 'cliente']);
    Route::get('/dbup/orden', [DbUpController::class, 'orden']);
    Route::get('/dbup/servicios', [DbUpController::class, 'servicios']);

    // Ocupacon
    
    Route::get('/ocupacion', [OcupacionController::class, 'index'])->name('index_ocupacion'); //le da un nombre a la ruta
    Route::get('/ocupacion/formulario/{id?}', [OcupacionController::class, 'formulario']);
    Route::post('/ocupacion/save', [OcupacionController::class, 'save']);

    // DashBoard
    Route::get('/dashboard', [DashBoardController::class, 'index']);
    //Route::get('/dashboard/ventas', [DashBoardController::class, 'total_ventas']);
    Route::match(['POST','GET'],'/dashboard/ventas', [DashBoardController::class, 'total_ventas']);
    Route::get('/dashboard/ventas/canal', [DashBoardController::class, 'total_canal']);
    Route::get('/dashboard/ventas/categoria', [DashBoardController::class, 'total_categorias']);//categoria_habitacion
    Route::get('/dashboard/ventas/habitacion', [DashBoardController::class, 'total_productos']);//habitacion
    Route::match(['POST','GET'],'/dashboard/ventas/productoxgenero', [DashBoardController::class, 'total_ventas_productoxgenero']);//habitacion
    //Route::Get('/dashboard/ventas/productoxgenero', [DashBoardController::class, 'total_ventas_productoxgenero']);//habitacion
    //Route::get('/dashboard/demograficos/genero', [DashBoardController::class, 'demograficos_genero']);
    Route::match(['POST','GET'],'/dashboard/demograficos/genero', [DashBoardController::class, 'demograficos_genero']);
    Route::match(['POST','GET'],'/dashboard/demograficos/edad', [DashBoardController::class, 'demograficos_edades']);
    
    

    // UNITY
    Route::get('/ver-carrito', [CarritoController::class,'verCarrito']);


//Aqui terminan las rutas del proyecto integrador (Hotel)

});













    












































