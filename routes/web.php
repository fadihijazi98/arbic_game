<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormsController;


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

Route::get('preview/{id}', 'FormsController@preview');//according to session id instead form id
Route::get('new_session/{id}', 'FormsController@newSession');

//Route::get('preview/{id}', function ($id) {
//    return view('game.preview', ['questions'=>\App\Models\Question::all()->where('form_id', $id)->values()]);
//});
Route::get('preview/{id}/admin','HomeController@admin')->name('preview.admin');
Route::post('/selected/save','FormsController@saveSeleted');
Route::get('/fetch','FormsController@fetch');
    Route::get('/fetch/{session_id}', 'FormsController@fetchQuestions');
Route::patch('/question/updateStatus/{id}','FormsController@updateStatus');
Route::get('score/{session_id}', 'FormsController@getScore');


Auth::routes(['register'=>false]);
Route::resource('form', 'FormsController')->middleware('auth');

Route::resource('question', 'QuestionsController')->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
