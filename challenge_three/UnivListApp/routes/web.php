<?php

use App\Http\Controllers\Controller;
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

Route::get('/', [Controller::class, 'index']);


/*
    API Routes
*/

Route::group(array('prefix' => 'api'), function()
{
    Route::resource('univ-api', 'App\Http\ApiController\ProcessApiController', array('only' => array('index')));
});
