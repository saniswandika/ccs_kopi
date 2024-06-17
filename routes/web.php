<?php

use Illuminate\Support\Facades\Route;

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

// Route::group(['namespace' => 'App\Http\Controllers'], function()
// {   
//     /**
//      * Home Routes
//      */
//     Route::get('/', 'HomeController@index')->name('home.index');

//     Route::group(['middleware' => ['guest']], function() {
//         /**
//          * Register Routes
//          */
//         Route::get('/register', 'RegisterController@show')->name('register.show');
//         Route::post('/register', 'RegisterController@register')->name('register.perform');

//         /**
//          * Login Routes
//          */
//         Route::get('/login', 'LoginController@show')->name('login.show');
//         Route::post('/login', 'LoginController@login')->name('login.perform');

//     });

//     Route::group(['middleware' => ['auth', 'permission']], function() {
//         /**
//          * Logout Routes
//          */
//         Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

//         /**
//          * User Routes
//          */


//         /**
//          * User Routes
//          */
//         Route::group(['prefix' => 'posts'], function() {
//             Route::get('/', 'PostsController@index')->name('posts.index');
//             Route::get('/create', 'PostsController@create')->name('posts.create');
//             Route::post('/create', 'PostsController@store')->name('posts.store');
//             Route::get('/{post}/show', 'PostsController@show')->name('posts.show');
//             Route::get('/{post}/edit', 'PostsController@edit')->name('posts.edit');
//             Route::patch('/{post}/update', 'PostsController@update')->name('posts.update');
//             Route::delete('/{post}/delete', 'PostsController@destroy')->name('posts.destroy');
//         });

//         Route::resource('roles', RolesController::class);
//         Route::resource('permissions', PermissionsController::class);
//     });
// });
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;   
use App\Http\Controllers\UsersController;  
use App\Http\Controllers\KriteriaController;  
use App\Http\Controllers\BijiKopiController;
use App\Http\Controllers\PerhitunganController;

Route::get('/', function () {return redirect('/dashboard');})->middleware('auth');
	Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
	Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
	Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
	Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
	Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
	Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
	Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
	Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
    
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria')->middleware('auth');
    Route::post('/kriteria/tambah', [KriteriaController::class, 'storeTambah'])->name('store-kriteria')->middleware('auth');
    Route::get('/kriteria/{kriteria}', [KriteriaController::class, 'edit'])->name('kriteria.edit')->middleware('auth');
    Route::put('/kriteria/{kriteria}', [KriteriaController::class, 'storeEdit'])->name('kriteria.update')->middleware('auth');
    Route::delete('/kriteria/{kriteria}', [KriteriaController::class, 'destroy'])->name('kriteria.delete')->middleware('auth');

    Route::get('/biji-kopi', [BijiKopiController::class, 'index'])->name('biji-kopi')->middleware('auth');
    Route::post('/biji-kopi/tambah', [BijiKopiController::class, 'storeTambah'])->name('store-biji-kopi')->middleware('auth');
    Route::get('/biji-kopi/{bijikopi}', [BijiKopiController::class, 'edit'])->name('biji-kopi.edit')->middleware('auth');
    Route::put('/biji-kopi/{bijikopi}', [BijiKopiController::class, 'storeEdit'])->name('biji-kopi.edit.post')->middleware('auth');
    Route::delete('/biji-kopi/{bijikopi}', [BijiKopiController::class, 'destroy'])->name('biji-kopi.delete')->middleware('auth');
    Route::get('/bijikopi/datatables', [BijiKopiController::class, 'bijikopiDatatables'])->name('bijikopi.datatables');
    
    Route::get('/perhitungan', [PerhitunganController::class, 'index'])->name('perhitungan')->middleware('auth');


    Route::group(['middleware' => 'auth'], function () {    
        Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
        Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
        Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
        Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static'); 
        Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
        Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static'); 
        Route::get('/{page}', [PageController::class, 'index'])->name('page');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        Route::prefix('users')->group(function() {
            Route::get('/', [UsersController::class, 'index'])->name('users.index');
            Route::get('/create', [UsersController::class, 'create'])->name('users.create');
            Route::post('/create', [UsersController::class, 'store'])->name('users.store');
            Route::get('/{user}/show', [UsersController::class, 'show'])->name('users.show');
            Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
            Route::patch('/{user}/update', [UsersController::class, 'update'])->name('users.update');
            Route::delete('/{user}/delete', [UsersController::class, 'destroy'])->name('users.destroy');
        });
});