<?php

use App\Models\Chat;
use Illuminate\Support\Facades\DB;
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


Route::get('/manger/show/group', function () {
    $user=DB::table('users')
    ->join('members', 'users.id', '=', 'members.member_id') // جلب بيانات الفريق
    ->where('members.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
    ->where('users.role' , 'member')
    ->select('users.*') // استخراج بيانات المدراء فقط
    ->get();
$unreadMessagesCount = Chat::where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->count();
$unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
    ->where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->groupBy('sender_id')
    ->get()
    ->keyBy('sender_id');
return view('manger.group.table-group' , compact('user' ,'unreadMessagesCount' , 'unreadMessages') );
})->name('manger.show.group');
Route::get('/manger/add/group', function () {
    $user=DB::table('users')
    ->join('members', 'users.id', '=', 'members.member_id') // جلب بيانات الفريق
    ->where('members.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
    ->where('users.role' , 'member')
    ->select('users.*') // استخراج بيانات المدراء فقط
    ->get();
$unreadMessagesCount = Chat::where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->count();
$unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
    ->where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->groupBy('sender_id')
    ->get()
    ->keyBy('sender_id');
return view('manger.group.add-group' , compact('user' ,'unreadMessagesCount' , 'unreadMessages') );
})->name('manger.add.group');
Route::get('/manger/edit/group', function () {
    $user=DB::table('users')
    ->join('members', 'users.id', '=', 'members.member_id') // جلب بيانات الفريق
    ->where('members.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
    ->where('users.role' , 'member')
    ->select('users.*') // استخراج بيانات المدراء فقط
    ->get();
$unreadMessagesCount = Chat::where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->count();
$unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
    ->where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->groupBy('sender_id')
    ->get()
    ->keyBy('sender_id');
return view('manger.group.edit-group' , compact('user' ,'unreadMessagesCount' , 'unreadMessages') );
})->name('manger.edit.group');
Route::get('/manger/show/team', function () {
    $user=DB::table('users')
    ->join('members', 'users.id', '=', 'members.member_id') // جلب بيانات الفريق
    ->where('members.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
    ->where('users.role' , 'member')
    ->select('users.*') // استخراج بيانات المدراء فقط
    ->get();
$unreadMessagesCount = Chat::where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->count();
$unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
    ->where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->groupBy('sender_id')
    ->get()
    ->keyBy('sender_id');
return view('manger.group.table-team' , compact('user' ,'unreadMessagesCount' , 'unreadMessages') );
})->name('manger.show.team');
Route::get('/manger/show/task', function () {
    $user=DB::table('users')
    ->join('members', 'users.id', '=', 'members.member_id') // جلب بيانات الفريق
    ->where('members.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
    ->where('users.role' , 'member')
    ->select('users.*') // استخراج بيانات المدراء فقط
    ->get();
$unreadMessagesCount = Chat::where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->count();
$unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
    ->where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->groupBy('sender_id')
    ->get()
    ->keyBy('sender_id');
return view('manger.group.table-task' , compact('user' ,'unreadMessagesCount' , 'unreadMessages') );
   
})->name('manger.show.task');
Route::get('/manger/edit/task', function () {
    $user=DB::table('users')
    ->join('members', 'users.id', '=', 'members.member_id') // جلب بيانات الفريق
    ->where('members.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
    ->where('users.role' , 'member')
    ->select('users.*') // استخراج بيانات المدراء فقط
    ->get();
$unreadMessagesCount = Chat::where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->count();
$unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
    ->where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->groupBy('sender_id')
    ->get()
    ->keyBy('sender_id');
return view('manger.group.edit-task' , compact('user' ,'unreadMessagesCount' , 'unreadMessages') );
})->name('manger.edit.task');


Route::get('/member/show/task', function () {
    $user = DB::table('users')
    ->join('members', 'members.manger_id', '=', 'users.id') // جلب بيانات الفريق
    ->where('members.member_id' , Auth::user()->id)
    ->select('users.*') // استخراج بيانات المدراء فقط
    ->distinct() // تجنب التكرار في حالة تعدد المهام
    ->get();
$unreadMessagesCount = Chat::where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->count();
$unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
    ->where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->groupBy('sender_id')
    ->get()
    ->keyBy('sender_id');
return view('member.task.table' , compact('user' ,'unreadMessagesCount' , 'unreadMessages') );
})->name('member.show.task');
Route::get('/member/show/team', function () {
    $user = DB::table('users')
    ->join('members', 'members.manger_id', '=', 'users.id') // جلب بيانات الفريق
    ->where('members.member_id' , Auth::user()->id)
    ->select('users.*') // استخراج بيانات المدراء فقط
    ->distinct() // تجنب التكرار في حالة تعدد المهام
    ->get();
$unreadMessagesCount = Chat::where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->count();
$unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
    ->where('receiver_id', auth()->id())
    ->where('is_read', 0)
    ->groupBy('sender_id')
    ->get()
    ->keyBy('sender_id');
return view('member.group.table' , compact('user' ,'unreadMessagesCount' , 'unreadMessages') );
})->name('member.show.team');
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
    Route::get('/show/member',[App\Http\Controllers\HomeController::class, 'show_member'])->name('manger.show.member');
    Route::get('/add/member', [App\Http\Controllers\HomeController::class, 'add_member'])->name('manger.add.member');
    Route::post('/add/member', [App\Http\Controllers\HomeController::class, 'store_member'])->name('manger.store.member');
    Route::delete('/delete/member/{id}', [App\Http\Controllers\HomeController::class, 'delete_member'])->name('manger.delete.user');


});










