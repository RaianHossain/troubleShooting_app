<?php

use App\Http\Controllers\IssueController;
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

Route::controller(IssueController::class)->prefix('issues')->group(function () {
    Route::get('/', 'index')->name('issues.index');
    Route::get('/pendigs', 'pendingIndex')->name('issues.pendingIndex');
    Route::get('/running', 'runningIndex')->name('issues.runningIndex');
    Route::get('/done', 'doneIndex')->name('issues.doneIndex');
    Route::get('/create', 'create')->name('issues.create');
    Route::delete('/delete/{issue_id}', 'delete')->name('issues.delete');
    Route::post('/', 'store')->name('issues.store');
});
