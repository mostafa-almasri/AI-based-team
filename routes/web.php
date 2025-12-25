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

    Route::get('/profile',  [App\Http\Controllers\HomeController::class, 'profile_member'])->name('member.profile');
    Route::put('/profile',  [App\Http\Controllers\HomeController::class, 'update_member'])->name('member.update.profile');
    Route::get('/skill/show',[App\Http\Controllers\HomeController::class, 'show_skill'])->name('member.show.skill');
    Route::get('/skill/add',[App\Http\Controllers\HomeController::class, 'add_skill'])->name('member.add.skill');
    Route::post('/skill/add',[App\Http\Controllers\HomeController::class, 'store_skill'])->name('member.store.skill');
    Route::delete('/skill/delete/{id}', [App\Http\Controllers\HomeController::class, 'delete_skill'])->name('member.delete.skill');
    Route::get('/skill/edit/{id}',[App\Http\Controllers\HomeController::class, 'edit_skill'])->name('member.edit.skill');
    Route::put('/skill/edit',[App\Http\Controllers\HomeController::class, 'update_skill'])->name('member.update.skill');
    Route::get('/group/show/group',[App\Http\Controllers\HomeController::class, 'show_my_group'])->name('member.show.team');
    Route::get('/group/show/team/{id}', [App\Http\Controllers\HomeController::class, 'show_team'])->name('member.table.team');
    Route::get('/group/show/{id}', [App\Http\Controllers\HomeController::class, 'show_task_member'])->name('member.table.task');
    Route::get('/task/show', [App\Http\Controllers\HomeController::class, 'show_my_task'])->name('member.show.task');
    Route::get('/task/add/document/{id}', [App\Http\Controllers\HomeController::class, 'add_document'])->name('member.add.document');
    Route::post('/task/add/document', [App\Http\Controllers\HomeController::class, 'store_document'])->name('member.store.document');
    Route::get('/notifications', [App\Http\Controllers\NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/mark-all-read', [App\Http\Controllers\NotificationsController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::post('/toggleAvailability',  [App\Http\Controllers\HomeController::class, 'toggleAvailability'])->name('student.toggleAvailability');

});
Route::group(['prefix'=>'admin', 'middleware' =>['auth'  ] ] , function()
{
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile_admin'])->name('admin.profile');
    Route::put('/profile', [App\Http\Controllers\HomeController::class, 'update_admin'])->name('update.profile');
    Route::get('/user/show', [App\Http\Controllers\HomeController::class, 'show_manger'])->name('admin.show.user');
    Route::delete('/user/delete/{id}', [App\Http\Controllers\HomeController::class, 'delete_manger'])->name('admin.delete.user');
    Route::get('/user/add', [App\Http\Controllers\HomeController::class, 'add_manger'])->name('admin.add.user');
    Route::post('/user/add', [App\Http\Controllers\HomeController::class, 'store_manger'])->name('admin.store.user');


});
Route::group(['prefix'=>'manger' , 'middleware' =>['auth'  ]] , function()
{

    Route::get('/profile',[App\Http\Controllers\HomeController::class, 'profile_manger'])->name('manger.profile');
    Route::put('/profile', [App\Http\Controllers\HomeController::class, 'update_manger'])->name('manger.update.profile');
    Route::get('/task/progress/{id}',[App\Http\Controllers\HomeController::class, 'progress_task'])->name('project.tasks');

    Route::get('/group/add',[App\Http\Controllers\HomeController::class, 'add_group'])->name('manger.add.group');
    Route::post('/group/add',[App\Http\Controllers\HomeController::class, 'store_group'])->name('manger.store.group');
    Route::delete('/group/delete/{id}', [App\Http\Controllers\HomeController::class, 'delete_group'])->name('manger.delete.group');
    Route::get('/group/edit/{id}',[App\Http\Controllers\HomeController::class, 'edit_group'])->name('manger.edit.group');
    Route::put('/group/edit',[App\Http\Controllers\HomeController::class, 'update_group'])->name('manger.update.group');
    Route::put('/group/update',[App\Http\Controllers\HomeController::class, 'update_task'])->name('manger.update.task');
    Route::get('/group/show' ,[App\Http\Controllers\HomeController::class, 'show_group'])->name('manger.show.group');
    Route::get('/group/task/add/{id}' ,[App\Http\Controllers\HomeController::class, 'add_task'])->name('manger.add.task');
    Route::post('/group/add/task',[App\Http\Controllers\HomeController::class, 'store_task'])->name('manger.store.task');
    Route::get('/group/show/team/{id}', [App\Http\Controllers\HomeController::class, 'show_my_team'])->name('manger.show.team');
    Route::get('/group/show/task/{id}', [App\Http\Controllers\HomeController::class, 'show_task'])->name('manger.show.task');
    Route::get('/group/edit/task/{id}', [App\Http\Controllers\HomeController::class, 'edit_task'])->name('manger.edit.task');
    Route::get('/member/show',[App\Http\Controllers\HomeController::class, 'show_member'])->name('manger.show.member');
    Route::get('/member/add', [App\Http\Controllers\HomeController::class, 'add_member'])->name('manger.add.member');
    Route::post('/member/add', [App\Http\Controllers\HomeController::class, 'store_member'])->name('manger.store.member');
    Route::delete('/member/delete/{id}', [App\Http\Controllers\HomeController::class, 'delete_member'])->name('manger.delete.user');
    Route::get('/project/{id}/report', [App\Http\Controllers\HomeController::class, 'generate'])
    ->name('report.generate');


});




