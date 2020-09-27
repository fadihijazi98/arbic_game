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

Route::get('/', function () {
    return view('welcome');
});
Route::get('preview/{id}', function ($id) {
    return view('game.preview', ['questions'=>\App\Models\Question::all()->where('form_id', $id)->values()]);
});


Auth::routes(['register'=>false]);
Route::resource('form', App\Http\Controllers\FormsController::class)->middleware('auth');
Route::resource('question', App\Http\Controllers\QuestionsController::class)->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
