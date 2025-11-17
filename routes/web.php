<?php

use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();




Auth::routes();
Route::get('/chat/{id}', [App\Http\Controllers\HomeController::class, 'chat_manger'])->middleware('auth')->name('chat.manger');
Route::get('manger/chat/{id}', [App\Http\Controllers\HomeController::class, 'chat_member'])->middleware('auth')->name('chat.member');
Route::get('/chat/get-messages/{userId}', [App\Http\Controllers\HomeController::class, 'getMessages'])->middleware('auth');
Route::post('/chat/store-message', [App\Http\Controllers\HomeController::class, 'storeMessage'])->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix'=>'member' , 'middleware' =>['auth'  ]] , function()
{
    Route::post('/mark-as-read', function () {
        Chat::where('receiver_id', Auth()->id())
        ->where('is_read', 0)
        ->update(['is_read' => 1]);

    return response()->json(['success' => true]);
    })->name('markAsRead');
    Route::get('/profile',  [App\Http\Controllers\HomeController::class, 'profile_member'])->name('member.profile');
    Route::put('/profile',  [App\Http\Controllers\HomeController::class, 'update_member'])->name('member.update.profile');
    Route::get('/show/skill',[App\Http\Controllers\HomeController::class, 'show_skill'])->name('member.show.skill');
    Route::get('/add/skill',[App\Http\Controllers\HomeController::class, 'add_skill'])->name('member.add.skill');
    Route::post('/add/skill',[App\Http\Controllers\HomeController::class, 'store_skill'])->name('member.store.skill');
    Route::delete('/delete/skill/{id}', [App\Http\Controllers\HomeController::class, 'delete_skill'])->name('member.delete.skill');
    Route::get('/edit/skill/{id}',[App\Http\Controllers\HomeController::class, 'edit_skill'])->name('member.edit.skill');
    Route::put('/edit/skill',[App\Http\Controllers\HomeController::class, 'update_skill'])->name('member.update.skill');
    Route::get('/show/group',[App\Http\Controllers\HomeController::class, 'show_my_group'])->name('member.show.team');
    Route::get('/show/team/{id}', [App\Http\Controllers\HomeController::class, 'show_team'])->name('member.table.team');
    Route::get('/show/task', [App\Http\Controllers\HomeController::class, 'show_my_task'])->name('member.show.task');
    Route::get('/add/document/{id}', [App\Http\Controllers\HomeController::class, 'add_document'])->name('member.add.document');
    Route::post('/add/document', [App\Http\Controllers\HomeController::class, 'store_document'])->name('member.store.document');
    Route::get('/notifications', [App\Http\Controllers\NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/mark-all-read', [App\Http\Controllers\NotificationsController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/toggleAvailability',  [App\Http\Controllers\HomeController::class, 'toggleAvailability'])->name('student.toggleAvailability');

});
Route::group(['prefix'=>'admin', 'middleware' =>['auth'  ] ] , function()
{
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile_admin'])->name('admin.profile');
    Route::put('/profile', [App\Http\Controllers\HomeController::class, 'update_admin'])->name('update.profile');
    Route::get('/show/user', [App\Http\Controllers\HomeController::class, 'show_manger'])->name('admin.show.user');
    Route::delete('/delete/user/{id}', [App\Http\Controllers\HomeController::class, 'delete_manger'])->name('admin.delete.user');
    Route::get('/add/user', [App\Http\Controllers\HomeController::class, 'add_manger'])->name('admin.add.user');
    Route::post('/add/user', [App\Http\Controllers\HomeController::class, 'store_manger'])->name('admin.store.user');


});
Route::group(['prefix'=>'manger' , 'middleware' =>['auth'  ]] , function()
{
    Route::post('/mark-as-read', function () {
        Chat::where('receiver_id', Auth()->id())
        ->where('is_read', 0)
        ->update(['is_read' => 1]);

    return response()->json(['success' => true]);
    })->name('markAsRead');
    Route::get('/profile',[App\Http\Controllers\HomeController::class, 'profile_manger'])->name('manger.profile');
    Route::put('/profile', [App\Http\Controllers\HomeController::class, 'update_manger'])->name('manger.update.profile');
    Route::get('/task/progress/{id}',[App\Http\Controllers\HomeController::class, 'progress_task'])->name('project.tasks');

    Route::get('/add/group',[App\Http\Controllers\HomeController::class, 'add_group'])->name('manger.add.group');
    Route::post('/add/group',[App\Http\Controllers\HomeController::class, 'store_group'])->name('manger.store.group');
    Route::delete('/delete/group/{id}', [App\Http\Controllers\HomeController::class, 'delete_group'])->name('manger.delete.group');
    Route::get('/edit/group/{id}',[App\Http\Controllers\HomeController::class, 'edit_group'])->name('manger.edit.group');
    Route::put('/edit/group',[App\Http\Controllers\HomeController::class, 'update_group'])->name('manger.update.group');
    Route::put('/update/group',[App\Http\Controllers\HomeController::class, 'update_task'])->name('manger.update.task');
    Route::get('/show/group' ,[App\Http\Controllers\HomeController::class, 'show_group'])->name('manger.show.group');
    Route::get('/add/task/{id}' ,[App\Http\Controllers\HomeController::class, 'add_task'])->name('manger.add.task');
    Route::post('/add/task',[App\Http\Controllers\HomeController::class, 'store_task'])->name('manger.store.task');
    Route::get('/show/group/team/{id}', [App\Http\Controllers\HomeController::class, 'show_my_team'])->name('manger.show.team');
    Route::get('/show/group/task/{id}', [App\Http\Controllers\HomeController::class, 'show_task'])->name('manger.show.task');
    Route::get('/edit/group/task/{id}', [App\Http\Controllers\HomeController::class, 'edit_task'])->name('manger.edit.task');
    Route::get('/show/member',[App\Http\Controllers\HomeController::class, 'show_member'])->name('manger.show.member');
    Route::get('/add/member', [App\Http\Controllers\HomeController::class, 'add_member'])->name('manger.add.member');
    Route::post('/add/member', [App\Http\Controllers\HomeController::class, 'store_member'])->name('manger.store.member');
    Route::delete('/delete/member/{id}', [App\Http\Controllers\HomeController::class, 'delete_member'])->name('manger.delete.user');



});




