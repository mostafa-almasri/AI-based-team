<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Team;
use App\Models\User;
use App\Models\Skill;
use App\Models\Member;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::id())
        {
            $type = Auth()->user()->role;
            if ($type == 'manger') 
            {
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
                return view('manger.hom' , compact('user' ,'unreadMessagesCount' , 'unreadMessages') );
            }  
            elseif ($type == 'member')
            {
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
                return view('member.home' , compact('user' ,'unreadMessagesCount' , 'unreadMessages') );

            }
            elseif ($type == 'admin') 
            {
                return view('admin.home' );

            }
        }
    }

    public function show_manger()
    {
        $user= User::where('role' , 'manger')->get();
        return view('admin.user.table' , compact( 'user'));

    }

    public function delete_manger($id)
    {
        $user = User::where('id' , $id)->first();
        $user->delete();
        return redirect()-> back() -> with('status', ' Deleted Done ');
    }

    public function profile_admin()
    {
        return view('admin.profile'  );
    }

    public function update_admin(Request $request )
    {
        $request->validate([
            'name' => [
                'regex:/^[a-zA-Zء-ي\s]+$/u', 
                'max:255'
            ], 
            'email' => [
                'string', 
                'email', 
                'max:255', 
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com)$/'
            ], 
            'password' => [ 
                'string',   
                'min:8',
                'confirmed', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ], 
            'phone' => [
                'regex:/^\+963\d{8,9}$|^\+\d{1,3}\d{8,12}$/'
            ], 
            'age' => [
                'integer', 
                'between:20,60'
            ],     'job' => [  // إضافة شرط حقل job هنا
                'regex:/^\d{9}$/'
            ],
        ], [
            'name.regex' => 'The name must contain only letters and spaces.',
            'name.max' => 'The name must not exceed 255 characters.',
            
            'email.string' => 'The email address must be a valid string.',
            'email.email' => 'The email address must be a valid email format.',
            'email.max' => 'The email address must not exceed 255 characters.',
            'email.regex' => 'The email must be from one of the following domains: gmail.com, yahoo.com, or outlook.com.',
            
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@$!%*?&).',
            
            'phone.regex' => 'The phone number must be in a valid format starting with + followed by the country code and the correct number.',
            
            'age.integer' => 'The age must be an integer.',
            'age.between' => 'The age must be between 20 and 60 years.',
            
               
            'job.regex' => 'The job ID must be exactly 9 digits.'
        ]);
        $id = Auth::user()->id ;
        $user=User::find($id);
        $user -> name = $request->input('name') ;
        $user -> email = $request->input('email') ;
        $user -> phone = $request->input('phone') ;
        $user -> age = $request->input('age') ;
        $user -> job = $request->input('job') ;
        $user->update();
        return redirect()-> back()     ->with('status', 'Updated done');
    }

    public function add_manger()
    {
       return view('admin.user.add');
    }

    public function store_manger(Request $request )
    {
        $request->validate([
            'name' => [
                'required', 
                'regex:/^[a-zA-Zء-ي\s]+$/u', 
                'max:255'
            ], 
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com)$/'
            ], 
            'password' => [ 
                'required',  
                'string',   
                'min:8',
                'confirmed', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ], 
            'phone' => [
                'required', 
                'regex:/^\+963\d{8,9}$|^\+\d{1,3}\d{8,12}$/'
            ], 
            'age' => [
                'required', 
                'integer', 
                'between:20,60'
            ],     'job' => [  // إضافة شرط حقل job هنا
                'required',
                'regex:/^\d{9}$/'
            ],
        ], [
            'name.required' => 'The name is required.',
            'name.regex' => 'The name must contain only letters and spaces.',
            'name.max' => 'The name must not exceed 255 characters.',
            
            'email.required' => 'The email address is required.',
            'email.string' => 'The email address must be a valid string.',
            'email.email' => 'The email address must be a valid email format.',
            'email.max' => 'The email address must not exceed 255 characters.',
            'email.regex' => 'The email must be from one of the following domains: gmail.com, yahoo.com, or outlook.com.',
            
            'password.required' => 'The password is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@$!%*?&).',
            
            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number must be in a valid format starting with + followed by the country code and the correct number.',
            
            'age.required' => 'The age is required.',
            'age.integer' => 'The age must be an integer.',
            'age.between' => 'The age must be between 20 and 60 years.',
            
               
            'job.required' => 'The job ID is required.',
            'job.regex' => 'The job ID must be exactly 9 digits.'
        ]);
     
        $user=new User();
        $user -> name = $request->input('name') ;
        $user -> email = $request->input('email') ;
        $user -> phone = $request->input('phone') ;
        $user -> age = $request->input('age') ;
        $user -> role = 'manger' ;
        $user -> job = $request->input('job') ;
        $user -> password =Hash::make($request->input('password'));
        $user->save();
        return redirect()-> back()     ->with('status', 'Added Done' ) ;
 
    } 
    public function show_member()
    {
        $user=DB::table('users')
            ->join('members', 'users.id', '=', 'members.member_id') // جلب بيانات الفريق
            ->join('availabilities', 'users.id', '=', 'availabilities.user_id') // جلب  توفر العضو
            ->where('members.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
            ->where('users.role' , 'member')
            ->select('users.*' , 'availabilities.is_available') // استخراج بيانات المدراء فقط
            ->get();
        $unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
            ->where('receiver_id', auth()->id())
            ->where('is_read', 0)
            ->groupBy('sender_id')
            ->get()
            ->keyBy('sender_id');
        $unreadMessagesCount = Chat::where('receiver_id', auth()->id())
            ->where('is_read', 0)
            ->count();
        return view('manger.member.table' , compact( 'user' ,'unreadMessagesCount' , 'unreadMessages'));

    }

    public function delete_member($id)
    {
        $user = User::where('id' , $id)->first();
        $user->delete();
        return redirect()-> back() -> with('status', ' Deleted Done ');
    }

    public function profile_manger()
    {
         $user=DB::table('users')
            ->join('members', 'users.id', '=', 'members.member_id') // جلب بيانات الفريق
            ->where('members.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
            ->where('users.role' , 'member')
            ->select('users.*') // استخراج بيانات المدراء فقط
            ->get();
        $unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
            ->where('receiver_id', auth()->id())
            ->where('is_read', 0)
            ->groupBy('sender_id')
            ->get()
            ->keyBy('sender_id');
        $unreadMessagesCount = Chat::where('receiver_id', auth()->id())
            ->where('is_read', 0)
            ->count();
        return view('manger.profile'  , compact('user','unreadMessagesCount' , 'unreadMessages') );
    }
    public function update_manger(Request $request )
    {
        $request->validate([
            'name' => [
                'regex:/^[a-zA-Zء-ي\s]+$/u', 
                'max:255'
            ], 
            'email' => [
                'string', 
                'email', 
                'max:255', 
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com)$/'
            ], 
            'password' => [ 
                'string',   
                'min:8',
                'confirmed', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ], 
            'phone' => [
                'regex:/^\+963\d{8,9}$|^\+\d{1,3}\d{8,12}$/'
            ], 
            'age' => [
                'integer', 
                'between:20,60'
            ],
        ], [
            'name.regex' => 'The name must contain only letters and spaces.',
            'name.max' => 'The name must not exceed 255 characters.',
            
            'email.string' => 'The email address must be a valid string.',
            'email.email' => 'The email address must be a valid email format.',
            'email.max' => 'The email address must not exceed 255 characters.',
            'email.regex' => 'The email must be from one of the following domains: gmail.com, yahoo.com, or outlook.com.',
            
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@$!%*?&).',
            
            'phone.regex' => 'The phone number must be in a valid format starting with + followed by the country code and the correct number.',
            
            'age.integer' => 'The age must be an integer.',
            'age.between' => 'The age must be between 20 and 60 years.',
            
               
        ]);
        $id = Auth::user()->id ;
        $user=User::find($id);
        $user -> name = $request->input('name') ;
        $user -> email = $request->input('email') ;
        $user -> phone = $request->input('phone') ;
        $user -> age = $request->input('age') ;
        $user -> job = $request->input('job') ;
        $user->update();
        return redirect()-> back()     ->with('status', 'Updated done');
    }
    public function add_member()
    {
        $user=DB::table('users')
            ->join('members', 'users.id', '=', 'members.member_id') // جلب بيانات الفريق
            ->where('members.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
            ->where('users.role' , 'member')
            ->select('users.*') // استخراج بيانات المدراء فقط
            ->get();
        $unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
            ->where('receiver_id', auth()->id())
            ->where('is_read', 0)
            ->groupBy('sender_id')
            ->get()
            ->keyBy('sender_id');
        $unreadMessagesCount = Chat::where('receiver_id', auth()->id())
            ->where('is_read', 0)
            ->count();
        return view('manger.member.add' , compact('user' ,'unreadMessagesCount' , 'unreadMessages'));
    }
    public function store_member(Request $request )
    {
        $request->validate([
            'name' => [
                'required', 
                'regex:/^[a-zA-Zء-ي\s]+$/u', 
                'max:255'
            ], 
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com)$/'
            ], 
            'password' => [ 
                'required',  
                'string',   
                'min:8',
                'confirmed', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ], 
            'phone' => [
                'required', 
                'regex:/^\+963\d{8,9}$|^\+\d{1,3}\d{8,12}$/'
            ], 
            'age' => [
                'required', 
                'integer', 
                'between:20,60'
            ], 
            'job' => [  // إضافة شرط حقل job هنا
                'required',
                'regex:/^\d{9}$/'
            ],
        ], [
            'name.required' => 'The name is required.',
            'name.regex' => 'The name must contain only letters and spaces.',
            'name.max' => 'The name must not exceed 255 characters.',
            
            'email.required' => 'The email address is required.',
            'email.string' => 'The email address must be a valid string.',
            'email.email' => 'The email address must be a valid email format.',
            'email.max' => 'The email address must not exceed 255 characters.',
            'email.unique' => 'This email address is already in use.',
            'email.regex' => 'The email must be from one of the following domains: gmail.com, yahoo.com, or outlook.com.',
            
            'password.required' => 'The password is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@$!%*?&).',
            
            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number must be in a valid format starting with + followed by the country code and the correct number.',
            
            'age.required' => 'The age is required.',
            'age.integer' => 'The age must be an integer.',
            'age.between' => 'The age must be between 20 and 60 years.',

                    
            'job.required' => 'The job ID is required.',
            'job.regex' => 'The job ID must be exactly 9 digits.'
        ]);
        $user=new User();
        $user -> name = $request->input('name') ;
        $user -> email = $request->input('email') ;
        $user -> phone = $request->input('phone') ;
        $user -> age = $request->input('age') ;
        $user -> role = 'member' ;
        $user -> job = $request->input('job') ;
        $user -> password =Hash::make($request->input('password'));
        $user->save();
        $member = new Member();
        $member->manger_id = Auth::user()->id;
        $member->member_id = $user->id;
        $member->save();
        $availability = new Availability();
        $availability->	is_available = 1;
        $availability->user_id = $user->id;
        $availability->save();

        
        return redirect()-> back()     ->with('status', 'Added Done' ) ;
 
    } 


    public function profile_member()
    {
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

        return view('member.profile'  , compact('user','unreadMessagesCount' , 'unreadMessages') );
    }
    public function update_member(Request $request )
    {
        $request->validate([
            'name' => [
                'regex:/^[a-zA-Zء-ي\s]+$/u', 
                'max:255'
            ], 
            'email' => [
                'string', 
                'email', 
                'max:255', 
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com)$/'
            ], 
            'password' => [ 
                'string',   
                'min:8',
                'confirmed', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ], 
            'phone' => [
                'regex:/^\+963\d{8,9}$|^\+\d{1,3}\d{8,12}$/'
            ], 
            'age' => [
                'integer', 
                'between:20,60'
            ], 
     
        ], [
            'name.regex' => 'The name must contain only letters and spaces.',
            'name.max' => 'The name must not exceed 255 characters.',
            
            'email.string' => 'The email address must be a valid string.',
            'email.email' => 'The email address must be a valid email format.',
            'email.max' => 'The email address must not exceed 255 characters.',
            'email.unique' => 'This email address is already in use.',
            'email.regex' => 'The email must be from one of the following domains: gmail.com, yahoo.com, or outlook.com.',
            
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@$!%*?&).',
            
            'phone.regex' => 'The phone number must be in a valid format starting with + followed by the country code and the correct number.',
            
            'age.integer' => 'The age must be an integer.',
            'age.between' => 'The age must be between 20 and 60 years.',
        ]);
     
        $id = Auth::user()->id ;
        $user=User::find($id);
        $user -> name = $request->input('name') ;
        $user -> email = $request->input('email') ;
        $user -> phone = $request->input('phone') ;
        $user -> age = $request->input('age') ;
        $user -> job = $request->input('job') ;
        $user->update();
        return redirect()-> back()     ->with('status', 'Updated done');
    }
    public function show_skill()
    {
        $skill = Skill::where('member_id' , Auth::user()->id)->get();
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

        return view('member.skill.table' , compact('skill' , 'user','unreadMessagesCount' , 'unreadMessages') );

    }
    public function delete_skill($id)
    {
        $skill = Skill::where('id' , $id)->first();
        $skill->delete();
        return redirect()-> back() -> with('status', ' Deleted Done ');
    }
  
    public function add_skill()
    {
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
        return view('member.skill.add' , compact('user','unreadMessagesCount' , 'unreadMessages') );

    }
    public function store_skill(Request $request )
    {
        $request->validate([
            'skill' => ['required'], 
            'previous_record' => [ 'required',  'string'], 
        ]);
        $skill=new Skill();
        $skill -> skill = $request->input('skill') ;
        $skill -> previous_record = $request->input('previous_record') ;
        $skill -> member_id = Auth::user()->id;
        $skill->save();
        return redirect()-> back()     ->with('status', 'Added Done' ) ;
 
    } 
    public function edit_skill($id)
    {
        $skill = Skill::find($id);
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
        return view('member.skill.edit' , compact('skill' , 'user','unreadMessagesCount' , 'unreadMessages') );

    }

    public function update_skill(Request $request )
    {
        $id = $request->input('id');
        $skill= Skill::find($id);
        $skill -> skill = $request->input('skill') ;
        $skill -> previous_record = $request->input('previous_record') ;
        $skill->update();
        return redirect()-> back()     ->with('status', 'update Done' ) ;
 
    } 

    public function chat_manger($id)
    {
        $receive = User::find($id);
        $messages = Chat::where(function($query) use ($id) 
            {
                $query->where('sender_id', Auth::user()->id)
                    ->where('receiver_id', $id);
            })->orWhere(function($query) use ($id) 
            {
                $query->where('sender_id', $id)
                    ->where('receiver_id', Auth::user()->id);
            })->get();
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
        return view('member.chat' , compact('user' , 'receive' , 'id' , 'messages' ,'unreadMessagesCount' , 'unreadMessages') );
    }
    public function chat_member($id)
    {
        $receive = User::find($id);
        $messages = Chat::where(function($query) use ($id) 
        {
            $query->where('sender_id', Auth::user()->id)
                  ->where('receiver_id', $id);
        })->orWhere(function($query) use ($id) 
        {
            $query->where('sender_id', $id)
                  ->where('receiver_id', Auth::user()->id);
        })->get();
    $user = DB::table('users')
                    ->join('members', 'members.manger_id', '=', 'users.id') // جلب بيانات الفريق
                    ->where('members.member_id' , Auth::user()->id)
                    ->select('users.*') // استخراج بيانات المدراء فقط
                    ->distinct() // تجنب التكرار في حالة تعدد المهام
                    ->get();
        $unreadMessages = Chat::select('sender_id', DB::raw('count(*) as unread_count'))
            ->where('receiver_id', auth()->id())
            ->where('is_read', 0)
            ->groupBy('sender_id')
            ->get()
            ->keyBy('sender_id');
        $unreadMessagesCount = Chat::where('receiver_id', auth()->id())
            ->where('is_read', 0)
            ->count();

        return view('manger.chat' , compact( 'user' , 'receive' , 'id' , 'messages','unreadMessagesCount' , 'unreadMessages') );
    }

    public function getMessages($userId)
    {
        $messages = Chat::where(function($query) use ($userId) 
            {
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $userId);
            })->orWhere(function($query) use ($userId) 
            {
                $query->where('sender_id', $userId)
                      ->where('receiver_id', auth()->id());
            })
            ->orderBy('sent_at', 'asc')
            ->get();

        return response()->json($messages);
    }
    public function storeMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id', // تأكد من أن معرف المستخدم موجود
            'message' => 'required|string|max:255', // تأكد من أن الرسالة ليست فارغة
        ]);
    
        $message = Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'sent_at' => now(),
        ]);
    
        return response()->json($message);
    }
    
    public function toggleAvailability()
    {
        $availability = Availability::firstOrCreate(['user_id' => auth()->id()]);
        $availability->is_available = !$availability->is_available;
        $availability->save();
        return response()->json([
            'success' => true,
            'is_available' => $availability->is_available,
        ]);
    }
    
}
