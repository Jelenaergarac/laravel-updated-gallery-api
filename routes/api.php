<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[RegisterController::class, 'register']);
Route::post('/login',[LoginController::class,'login']);


//galleries
Route::get('/galleries',[GalleryController::class, 'index']);
Route::get('/galleries/{gallery}',[GalleryController::class,'show']);



Route::group(['middleware'=>['auth']], function(){
///my galleries
Route::get('/my-galleries/{user_id}',[GalleryController::class,'getMyGalleries']);
Route::post('/create-gallery',[GalleryController::class,'store']);
Route::put('/galleries/{gallery}',[GalleryController::class,'update']);
Route::delete('/galleries/{gallery}',[GalleryController::class,'destroy']);
///comments
Route::post('/galleries/{gallery}/comments',[CommentController::class,'store']);
Route::delete('/comments/{comment}',[CommentController::class,'destroy']);

Route::post('/logout',[LogoutController::class,'logout']);
});



