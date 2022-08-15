<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EngineerController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueResolveController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResolveController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WinnerController;

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

// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::controller(IssueController::class)->prefix('issues')->group(function () {
        Route::get('/', 'index')->name('issues.index');
        Route::get('/pending', 'pendingIndex')->name('issues.pendingIndex');
        Route::get('/running', 'runningIndex')->name('issues.runningIndex');
        Route::get('/done', 'doneIndex')->name('issues.doneIndex');
        Route::get('/my-uploaded/{user_id}', 'myUploaded')->name('issues.myUploaded');
        Route::get('/my-solved/{user_id}', 'mySolved')->name('issues.mySolved');
        Route::get('/my-bidded/{user_id}', 'myBidded')->name('issues.myBidded');
        Route::get('/create', 'create')->name('issues.create');
        Route::delete('/delete/{issue_id}', 'delete')->name('issues.delete');
        Route::post('/', 'store')->name('issues.store');
        Route::get('/upload-an-issue', 'uploadAnIssue')->name('issues.uploadAnIssue');
        Route::get('/issues-for-bid', 'biddableIssues')->name('issues.biddableIssues');
        Route::post('/upload-an-issue/store', 'upload')->name('issues.uplaod');
        Route::get('/show/{issue_id}', 'show')->name('issues.show');
    });
    
    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('/', 'index')->name('roles.index');    
        Route::get('/create', 'create')->name('roles.create');
        Route::delete('/delete/{role_id}', 'delete')->name('roles.delete');
        Route::post('/', 'store')->name('roles.store');
    });
    
    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index')->name('users.index');    
        Route::get('/create', 'create')->name('users.create');
        Route::delete('/delete/{user_id}', 'delete')->name('users.delete');
        Route::post('/', 'store')->name('users.store');
    });
    
    Route::controller(CenterController::class)->prefix('centers')->group(function () {
        Route::get('/', 'index')->name('centers.index');    
        Route::get('/create', 'create')->name('centers.create');
        Route::delete('/delete/{center_id}', 'delete')->name('centers.delete');
        Route::post('/', 'store')->name('centers.store');
    });
    
    Route::controller(BidController::class)->prefix('bids')->group(function () {
        Route::get('/', 'index')->name('bids.index'); 
        Route::get('/show-bids/{issue_id}', 'showBids')->name('bids.showBids');   
        Route::get('/create', 'create')->name('bids.create');
        Route::delete('/delete/{bid_id}', 'delete')->name('bids.delete');
        Route::post('/', 'store')->name('bids.store');
        Route::get('/bid-an-issue/{issue_id}', 'bidAnIssue')->name('bids.bidAnIssue');
        Route::post('/bid-issue/store', 'bidStore')->name('bids.bidStore');
    });
    
    Route::controller(WinnerController::class)->prefix('winners')->group(function () {
        Route::get('/', 'index')->name('winners.index');    
        Route::get('/create', 'create')->name('winners.create');
        Route::delete('/delete/{winner_id}', 'delete')->name('winners.delete');
        Route::post('/', 'store')->name('winners.store');
        Route::get('/assing/{issue_id}', 'assign')->name('winners.assign');
    });
    
    Route::controller(ResolveController::class)->prefix('resolves')->group(function () {
        Route::get('/', 'index')->name('resolves.index');    
        Route::get('/create', 'create')->name('resolves.create');
        Route::delete('/delete/{resolve_id}', 'delete')->name('resolves.delete');
        Route::post('/', 'store')->name('resolves.store'); 
        Route::post('/extend-request', 'extendRequest')->name('resolves.extendRequest'); 
        Route::get('/time-extend-request', 'timeExtendRequest')->name('resolves.timeExtendRequest'); 
        Route::get('/time-extend-request-approve/{resolve_id}/{request_id}', 'approveRequest')->name('resolves.approve');
        Route::get('/time-extend-request-reject/{resolve_id}/{request_id}', 'rejectRequest')->name('resolves.reject');
        Route::post('/complete-task', 'completeTask')->name('resolves.complete');
        Route::post('/give-up', 'giveup')->name('resolves.giveup');
    });
    
    Route::controller(IssueResolveController::class)->prefix('issueResolves')->group(function () {
        Route::get('/', 'index')->name('issueResolves.index');    
        Route::get('/create', 'create')->name('issueResolves.create');
        Route::delete('/delete/{issueResolve_id}', 'delete')->name('issueResolves.delete');
        Route::post('/', 'store')->name('issueResolves.store');
    });

    Route::controller(EngineerController::class)->prefix('engineers')->group(function () {
        Route::get('/', 'index')->name('engineers.index');    
        Route::get('/create', 'create')->name('engineers.create');
        Route::delete('/delete/{engineer_id}', 'delete')->name('engineers.delete');
        Route::post('/', 'store')->name('engineers.store');
    });
    
    Route::controller(NotificationController::class)->prefix('notifications')->group(function () {
        Route::get('/', 'index')->name('notifications.index');    
        Route::get('/create', 'create')->name('notifications.create');
        Route::delete('/delete/{notification_id}', 'delete')->name('notifications.delete');
        Route::post('/', 'store')->name('notifications.store');
    });
    
    // Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/resolving-now/{user_id}', [ResolveController::class, 'resolvingNow'])->name('resolving_now');
    Route::get('/task-to-assign', [IssueController::class, 'tasksToAssign'])->name('task_to_assign');
    Route::get('/profile/{user_id}', [UserController::class, 'profile'])->name('profile');

});


