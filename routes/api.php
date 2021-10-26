<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('cors')->group(function(){
	Route::get('fetch_menu_categories', [App\Http\Controllers\APIs\ApiController::class, 'fetchCategories']);
	Route::get('fetch_menu_subcategories', [App\Http\Controllers\APIs\ApiController::class, 'fetchSubcategories']);
});