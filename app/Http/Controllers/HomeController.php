<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Chat;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use App\Models\Skill;
use App\Models\Member;
use App\Models\Document;
use App\Models\Availability;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\ProgressHistory;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\PDF;

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
                    $manager_id = auth()->id();

                    // جلب كل المشاريع مع المهام
                    $teams = Team::with(['tasks', 'tasks.progressHistory'])
                    ->where('manger_id', $manager_id)
                    ->get();                
                  
                    $projects = $teams->map(function($team){

                        $completed   = $team->tasks->where('progress',100)->count();
                        $inProgress  = $team->tasks->whereBetween('progress',[1,99])->count();
                        $pending     = $team->tasks->where('progress',0)->count();
                    
                        //مهمة متأخرة
                        $lateTasks   = $team->tasks->filter(function($t){
                            return $t->finish_date < now() && $t->progress < 100;
                        })->count();
                    
                        $history = [];
                            foreach ($team->tasks as $task) {
                                foreach ($task->progressHistory as $h) {
                                    $date = Carbon::parse($h->recorded_at)->format('Y-m-d');
                                    if (!isset($history[$date])) $history[$date] = [];
                                    $history[$date][] = $h->progress;
                                }
                            }

                            // إنشاء محور التاريخ الموحد (مرتّب)
                            $allDates = collect(array_keys($history))->sort()->values(); // مجموعة من تواريخ 'Y-m-d'

                            // متوسط المشروع اليومي (محوري)
                            $timeline_progress = collect($history)->map(function($values){
                                return round(array_sum($values) / count($values));
                            })->only($allDates->all()); // نتأكّد أنها مرتبة طبقًا للـ allDates

                            // الآن نبني timeline لكل مهمة ولكن مع محاذاة للتواريخ الموحدة
                            $tasksTimeline = [];
                            foreach ($team->tasks as $task) {
                                // خريطة تاريخ => قيمة لهذه المهمة
                                $map = [];
                                foreach ($task->progressHistory as $h) {
                                    $d = Carbon::parse($h->recorded_at)->format('Y-m-d');
                                    $map[$d] = $h->progress;
                                }

                                // نُنشئ مصفوفة قيم بنفس ترتيب $allDates
                                $values = [];
                                $last = null;
                                foreach ($allDates as $date) {
                                    if (array_key_exists($date, $map)) {
                                        $last = $map[$date];
                                        $values[] = $map[$date];
                                    } else {
                                        // forward-fill: استخدم آخر قيمة معروفة كي لا يظهر انقطاع (يمكن تغييره إلى null إن أردت)
                                        $values[] = $last === null ? null : $last;
                                    }
                                }

                                $tasksTimeline[] = [
                                    'task_id'   => $task->id,
                                    'task_name' => $task->task_name,
                                    'isLate'    => ($task->finish_date < now() && $task->progress < 100),
                                    'values'    => $values
                                ];
                            }

                            // تحديد إن كان المشروع انتهى زمنه (قارن باستخدام Carbon)
                            $maxFinish = $team->time_frame; // قد يكون null
                            $projectLate = $maxFinish ? (Carbon::parse($maxFinish) < now()) : false;

                            // باقي حسابات الـ stacked كما لديك...
                            $completed   = $team->tasks->where('progress',100)->count();
                            $inProgress  = $team->tasks->whereBetween('progress',[1,99])->count();
                            $pending     = $team->tasks->where('progress',0)->count();
                        
                            return [
                                'name' => $team->project_name,
                                'progress' => $team->projectProgress(),

                                'tasks' => $team->tasks->map(function($t){
                                    return [
                                        'name'     => $t->task_name,
                                        'progress' => $t->progress,
                                        'start'    => $t->start_date,
                                        'end'      => $t->finish_date,
                                        'isLate'   => ($t->finish_date < now() && $t->progress < 100)
                                    ];
                                }),

                                // محور التواريخ الموحد (labels)
                                'timelineProgress' => [
                                    'dates' => $allDates->values(),          // مثال: ["2025-12-01","2025-12-03", ...]
                                    'values' => $timeline_progress->values(),// متوسط المشروع بالنسبة لكل تاريخ
                                ],

                                // قيم كل مهمة مصفوفة متوافقة مع dates
                                'tasksTimeline' => $tasksTimeline,

                                'stacked'=>[
                                    'completed'=>$completed,
                                    'inprogress'=>$inProgress,
                                    'pending'=>$pending,
                                ],

                                // لون المشروع (أرسِل boolean و لون إن أردت)
                                'projectLate' => $projectLate,
                                'color'=> $projectLate ? 'rgba(255,80,80,0.8)' : 'rgba(60,200,90,0.8)'
                            ];
                    
                    });
                    
                return view('manger.hom' , compact('projects' ,'user' ,'unreadMessagesCount' , 'unreadMessages') );
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
                $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
                $task = Task::where('member_id', Auth::user()->id) ->get();
                return view('member.hom' , compact('task','notifications' ,'user' ,'unreadMessagesCount' , 'unreadMessages') );

            }
            elseif ($type == 'admin') 
            {
                $minCreated = User::min('created_at');
                $firstDate = $minCreated
                    ? \Carbon\Carbon::parse($minCreated)->toDateString()
                    : now()->toDateString();

                $lastDate = now()->toDateString();
                $dates = collect();
                $current = Carbon::parse($firstDate);

                while ($current->lte($lastDate)) {
                    $dates->push($current->format('Y-m-d'));
                    $current->addDay();
                }

                $admins = User::where('role', 'member')
                ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->pluck('total', 'date');
                            $managers = User::where('role', 'manger')
                ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->pluck('total', 'date');
                $projects = Team::selectRaw('DATE(created_at) as date, COUNT(*) as total')
                ->groupBy('date')
                ->pluck('total', 'date');
                $data = [
                    'dates' => $dates,
                    'managers' => $dates->map(fn($d) => $managers[$d] ?? 0),
                    'member' => $dates->map(fn($d) => $admins[$d] ?? 0),
                    'projects' => $dates->map(fn($d) => $projects[$d] ?? 0),
                ];
                
            
                return view('admin.hom' , compact('data') );
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
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com)$/',
            ], 
            'phone' => [
                'regex:/^\+963\d{8,9}$|^\+\d{1,3}\d{8,12}$/',
            ], 
                 'job' => [ 
                'integer', 
                'regex:/^\d{9}$/',
            ],
        ], [
            'name.regex' => 'The name must contain only letters and spaces.',
            'name.max' => 'The name must not exceed 255 characters.',
            'email.string' => 'The email address must be a valid string.',
            'email.email' => 'The email address must be a valid email format.',
            'email.max' => 'The email address must not exceed 255 characters.',
            'email.regex' => 'The email must be from one of the following domains: gmail.com, yahoo.com, or outlook.com.',
            'phone.regex' => 'The phone number must be in a valid format starting with + followed by the country code and the correct number.',
            'job.regex' => 'The job ID must be exactly 9 digits.'
        ]);
        $id = Auth::user()->id ;
        $user=User::find($id);
        $user -> name = $request->input('name') ;
        $user -> email = $request->input('email') ;
        $user -> phone = $request->input('phone') ;
        if($request->hasfile('image'))
        {
   
            $file = $request->file('image');
            $extention = $file ->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/profile/' , $filename);
            $user->image = $filename ;
        }
        $user->update();
        return redirect()-> back()     ->with('status', 'Updated done');
    }

    public function add_manger()
    {
       return view('admin.user.add');
    }

    public function store_manger(Request $request)
    {
        $request->validate([
            'name' => [
                'required', 
                'regex:/^[a-zA-Zء-ي\s]+$/u', 
                'unique:users',
                'max:255',
            ], 
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|outlook\.com)$/',
            ], 
            'password' => [ 
                'required',  
                'string',   
                'min:8',
                'confirmed', 
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            ], 
            'phone' => [
                'required', 
                'regex:/^\+963\d{8,9}$|^\+\d{1,3}\d{8,12}$/',
            ], 
              'job' => [ 
                'required',
                'integer', 
                'unique:users',
                'regex:/^\d{9}$/',
            ],
        ], [
            'name.required' => 'The name is required.',
            'name.regex' => 'The name must contain only letters and spaces.',
            'name.max' => 'The name must not exceed 255 characters.',
            'name.unique' => 'This user name  is already in use.',
            'email.required' => 'The email address is required.',
            'email.string' => 'The email address must be a valid string.',
            'email.email' => 'The email address must be a valid email format.',
            'email.max' => 'The email address must not exceed 255 characters.',
            'email.regex' => 'The email must be from one of the following domains: gmail.com, yahoo.com, or outlook.com.',
            'email.unique' => 'This email address  is already in use.',
            'password.required' => 'The password is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one number, and one special character (@$!%*?&).',
            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number must be in a valid format starting with + followed by the country code and the correct number.',
            'job.required' => 'The job ID is required.',
            'job.regex' => 'The job ID must be exactly 9 digits.' ,
            'job.unique' => 'This job id  is already in use.'
        ]);
        $user=new User();
        $user -> name = $request->input('name') ;
        $user -> email = $request->input('email') ;
        $user -> phone = $request->input('phone') ;
        $user -> role = 'manger' ;
        $user -> job = $request->input('job') ;
        $user -> password =Hash::make($request->input('password'));
        if($request->hasfile('image'))
        {
            if (isset($user->image) )
            {
                $destination = 'uploads/profile/'.$user->image;
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
            }
            $file = $request->file('image');
            $extention = $file ->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/profile/' , $filename);
            $user->image = $filename ;
        }
        $user->save();
        return redirect()-> back()     ->with('status', 'Added Done' ) ;
    } 
    public function show_member()
    {
        $user = User::where('role', 'member')
        ->whereHas('teamMembers', function($q){
            $q->where('manger_id', Auth::id());
        })
        ->with(['skills', 'availability','tasks.team'])
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
        return view('manger.member.table' , compact( 'user' , 'unreadMessagesCount' , 'unreadMessages'));
    }

    public function progress_task()
    {
        $user=DB::table('users')
            ->join('members', 'users.id', '=', 'members.member_id') // جلب بيانات الفريق
            ->join('availabilities', 'users.id', '=', 'availabilities.user_id') // جلب  توفر العضو
            ->where('members.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
            ->where('users.role' , 'member')
            ->select('users.*' , 'availabilities.is_available') // استخراج بيانات المدراء فقط
            ->distinct()
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
            $task = DB::table('tasks')
            ->join('teams', 'teams.id', '=', 'tasks.team_id') // جلب بيانات الفريق
            ->join('users', 'users.id', '=', 'tasks.member_id') // جلب بيانات الفريق
            ->where('teams.manger_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
            ->select('tasks.*' , 'users.*' , 'teams.*') 
            ->get();
        return view('manger.group.progress-task' , compact('task' , 'user' , 'unreadMessagesCount' , 'unreadMessages'));
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

            'phone' => [
                'regex:/^\+963\d{8,9}$|^\+\d{1,3}\d{8,12}$/'
            ], 
   
        ], [
            'name.regex' => 'The name must contain only letters and spaces.',
            'name.max' => 'The name must not exceed 255 characters.',
            
            'email.string' => 'The email address must be a valid string.',
            'email.email' => 'The email address must be a valid email format.',
            'email.max' => 'The email address must not exceed 255 characters.',
            'email.regex' => 'The email must be from one of the following domains: gmail.com, yahoo.com, or outlook.com.',

            'phone.regex' => 'The phone number must be in a valid format starting with + followed by the country code and the correct number.',
         
        ]);
        $id = Auth::user()->id ;
        $user=User::find($id);
        $user -> name = $request->input('name') ;
        $user -> email = $request->input('email') ;
        $user -> phone = $request->input('phone') ;
        if($request->hasfile('image'))
        {
            $file = $request->file('image');
            $extention = $file ->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/profile/' , $filename);
            $user->image = $filename ;
        }
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
                'max:255', 
                'unique:users',

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
   
            'job' => [ 
                'required',
                'integer',
                'regex:/^\d{9}$/',
                'unique:users',

            ],
        ], [
            'name.required' => 'The name is required.',
            'name.regex' => 'The name must contain only letters and spaces.',
            'name.max' => 'The name must not exceed 255 characters.',
            'name.unique' => 'This user name is already in use.',

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
            
            'job.required' => 'The job ID is required.',
            'job.regex' => 'The job ID must be exactly 9 digits.' ,
            'job.unique' => 'This job id is already in use.',

        ]);
        $user=new User();
        $user -> name = $request->input('name') ;
        $user -> email = $request->input('email') ;
        $user -> phone = $request->input('phone') ;
        $user -> role = 'member' ;
        $user -> job = $request->input('job') ;
        $user -> password =Hash::make($request->input('password'));
        
        if($request->hasfile('image'))
        {
            if (isset($user->image) )
            {
                $destination = 'uploads/profile/'.$user->image;
                if(File::exists($destination))
                {
                    File::delete($destination);
                }
            }
            $file = $request->file('image');
            $extention = $file ->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/profile/' , $filename);
            $user->image = $filename ;
        }
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
            $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('member.profile'  , compact('notifications' ,'user','unreadMessagesCount' , 'unreadMessages') );
    }
    public function update_member(Request $request )
    {
        $request->validate([
            'name' => [
                'regex:/^[a-zA-Zء-ي\s]+$/u', 
                'max:255' ,

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
        ]);
     
        $id = Auth::user()->id ;
        $user=User::find($id);
        $user -> name = $request->input('name') ;
        $user -> email = $request->input('email') ;
        $user -> phone = $request->input('phone') ;
        if($request->hasfile('image'))
        {
           
            $file = $request->file('image');
            $extention = $file ->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/profile/' , $filename);
            $user->image = $filename ;
        }
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
            $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('member.skill.table' , compact('notifications' ,'skill' , 'user','unreadMessagesCount' , 'unreadMessages') );

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
            $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('member.skill.add' , compact('notifications' ,'user','unreadMessagesCount' , 'unreadMessages') );

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
            $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('member.skill.edit' , compact('notifications' ,'skill' , 'user','unreadMessagesCount' , 'unreadMessages') );

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
           $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
           $unread = Chat::where('sender_id', $receive->id)
           ->where('receiver_id', auth()->id())
           ->where('is_read', 0)
           ->update(['is_read' => 1]);
        return view('member.chat' , compact('notifications' , 'user' , 'receive' , 'id' , 'messages' ,'unreadMessagesCount' , 'unreadMessages') );
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

        $unread = Chat::where('sender_id', $receive->id)
        ->where('receiver_id', auth()->id())
        ->where('is_read', 0)
        ->update(['is_read' => 1]);
      
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
    

    
    public function show_group()
    {
        $group = Team::with('members')->where('manger_id', Auth::id())->get();
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
        return view('manger.group.table-group' , compact('group' , 'user' ,'unreadMessagesCount' , 'unreadMessages') );

    }
    public function delete_group($id)
    {
        $group = Team::where('id' , $id)->first();
        $group->delete();
        return redirect()-> back() -> with('status', ' Deleted Done ');
    }
  
    public function add_group()
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
        return view('manger.group.add-group' , compact('user','unreadMessagesCount' , 'unreadMessages'));

    }

    
    public function store_group(Request $request)
    {
        // ✅ 1️⃣ التحقق من البيانات المدخلة
        $validated = $request->validate([
            'project_name' => ['required', 'string', 'max:255'],
            'project_field' => ['required', 'string'],
            'time_frame' => ['required'],
            'count_team' => ['required', 'integer', 'min:1'],
            'skills' => ['required', 'array', 'min:1'], // ✅ تأكيد أن المهارات ليست فارغة
        ]);
        // إذا كان time_frame هو عدد الأيام
        $end_date = now()->addDays($validated['time_frame']);

    
        // ✅ 2️⃣ إنشاء المشروع وتخزين البيانات في قاعدة البيانات
        $team = new Team();
        $team->project_name = $validated['project_name'];
        $team->project_field = $validated['project_field'];
        $team->count_team = $validated['count_team'];
        $team->project_skill = json_encode($validated['skills']);
        $team->time_frame = $validated['time_frame'];
        $team->manger_id = Auth::user()->id;
        $team->save();

        return redirect()-> route('manger.show.group')->with('status', 'Project created successfully!');
    }
    
    public function edit_group($id)
    {
        $group = Team::find($id);
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

        return view('manger.group.edit-group' , compact('group' , 'user','unreadMessagesCount' , 'unreadMessages') );

    }

    public function update_group(Request $request )
    {
        $validated = $request->validate([
            'skills' => 'required|array|min:1', // التأكد من أن المهارات ليست فارغة
        ]);
        $id = $request->input('id');
        $team= Team::find($id);
        $team -> project_name = $request->input('project_name') ;
        $team -> project_field = $request->input('project_field') ;
        $team -> count_team = $request->input('count_team') ;
        $team->project_skill = json_encode($validated['skills']); 
        $team -> time_frame = $request->input('time_frame') ;
        $team->update();
        return redirect()-> route('manger.show.group')     ->with('status', 'update Done' ) ;
 
    } 
  

    public function show_my_team($id)
    {
        $member = DB::table('users')
        ->join('tasks', 'users.id', '=', 'tasks.member_id')
        ->where('tasks.team_id', $id)
        ->select('users.*')
        ->distinct() // تجنب التكرار
        ->get();
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
        return view('manger.group.table-team' , compact('member' , 'user','unreadMessagesCount' , 'unreadMessages') );
    }
    public function add_task($id)
    {
        $team = Team::find($id);
        $projectSkills = json_decode($team->project_skill, true); 
        $member = DB::table('users')
        ->join('skills', 'users.id', '=', 'skills.member_id') 
        ->join('availabilities', 'users.id', '=', 'availabilities.user_id') 
        ->where('role' , 'member')
        ->whereIn('skills.skill', $projectSkills)
        ->select(
            'users.id',
            'users.name',
            'availabilities.is_available',
            DB::raw('GROUP_CONCAT(skills.skill SEPARATOR ", ") as member_skills')
        )
        ->groupBy('users.id', 'users.name', 'availabilities.is_available')
        ->get();
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
        return view('manger.group.add-task' , compact('team' , 'member' , 'user','unreadMessagesCount' , 'unreadMessages') );
    }
  
    public function show_task($id)
    {
        $task = Task::where('team_id' , $id)->
        with(['document', 'member' , 'team'])->get();
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
        return view('manger.group.table-task' , compact('task' , 'user','unreadMessagesCount' , 'unreadMessages') );
    }
    public function store_task(Request $request )
    {
        $finish_date = $request->input('finish_date') ;
        $start_date = $request->input('start_date') ;

        $id = $request->input('team');
        $team= Team::find($id);
        $task = new Task();
        $task -> member_id = $request->input('member') ;
        $task -> team_id = $team->id ;
        $task -> task_name = $request->input('name') ;
        $task -> start_date = $start_date;
        $task -> finish_date = $finish_date ;
        $task -> task_duration =   \Carbon\Carbon::parse($finish_date)->diffInDays(\Carbon\Carbon::parse($start_date));
        $task->save();
        Notification::create([
            'user_id' => $task['member_id'],
            'message' => "📌 Task Assigned: '{$task->task_name}' in '{$team->project_name}' from {$task->start_date} to {$task->finish_date} "
        ]);
            
        return redirect()-> route('manger.show.group')     ->with('status', 'add task successfully!' ) ;
 
    }
    public function edit_task($id)
    {
        $task = Task::where('id' , $id)->
        with(['document', 'member' , 'team'])->first();
        $team = Team::find($task->team_id);
        $projectSkills = json_decode($team->project_skill, true); 
        $member = DB::table('users')
        ->join('skills', 'users.id', '=', 'skills.member_id') 
        ->join('availabilities', 'users.id', '=', 'availabilities.user_id') 
        ->where('role' , 'member')
        ->whereIn('skills.skill', $projectSkills)
        ->select(
            'users.id',
            'users.name',
            'availabilities.is_available',
            DB::raw('GROUP_CONCAT(skills.skill SEPARATOR ", ") as member_skills')
        )
        ->groupBy('users.id', 'users.name', 'availabilities.is_available')
        ->get();
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

        return view('manger.group.edit-task' , compact('member' , 'task' , 'user','unreadMessagesCount' , 'unreadMessages') );
    }

    public function update_task(Request $request )
    {
     
        $id = $request->input('id');
        $task= Task::find($id);
        $task -> member_id = $request->input('member') ;
        $task -> finish_date = $request->input('finish_date') ;

        $task->update();
        return redirect()-> route('manger.show.group')     ->with('status', 'update Done' ) ;
 
    }

    public function show_my_group()
    {
        $group = DB::table('tasks')
        ->join('teams', 'teams.id', '=', 'tasks.team_id')
        ->join('users', 'users.id', '=', 'tasks.member_id')
        ->where('tasks.member_id', Auth::user()->id)
        ->select( 'teams.*')
        ->distinct()
        ->get();
        $user = DB::table('tasks')
        ->join('teams', 'teams.id', '=', 'tasks.team_id') // جلب بيانات الفريق
        ->join('users as managers', 'managers.id', '=', 'teams.manger_id') // جلب بيانات المدير
        ->where('tasks.member_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
        ->select('managers.*') // استخراج بيانات المدراء فقط
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
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('member.group.table' , compact('notifications' ,'group' , 'user' ,'unreadMessagesCount' , 'unreadMessages') );
    }
    public function show_team($id)
    {
        $member = DB::table('users')
        ->join('tasks', 'users.id', '=', 'tasks.member_id')
        ->where('tasks.team_id', $id)
        ->select('users.*')
        ->distinct()
        ->get();
        $user = DB::table('tasks')
        ->join('teams', 'teams.id', '=', 'tasks.team_id') // جلب بيانات الفريق
        ->join('users as managers', 'managers.id', '=', 'teams.manger_id') // جلب بيانات المدير
        ->where('tasks.member_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
        ->select('managers.*') // استخراج بيانات المدراء فقط
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
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('member.group.team' , compact('notifications' , 'member' , 'user' ,'unreadMessagesCount' , 'unreadMessages') );
    }
    public function show_task_member($id)
    {
        $task = Task::where('team_id' , $id)->get();
        $user = DB::table('tasks')
        ->join('teams', 'teams.id', '=', 'tasks.team_id') // جلب بيانات الفريق
        ->join('users as managers', 'managers.id', '=', 'teams.manger_id') // جلب بيانات المدير
        ->where('tasks.member_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
        ->select('managers.*') // استخراج بيانات المدراء فقط
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
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('member.group.table-task' , compact('notifications' , 'task' , 'user' ,'unreadMessagesCount' , 'unreadMessages') );
    }
    public function show_my_task()
    {
        $task = Task::where('member_id' , Auth::user()->id)->
        with(['document', 'member' , 'team'])->get();

        $user = DB::table('tasks')
        ->join('teams', 'teams.id', '=', 'tasks.team_id') // جلب بيانات الفريق
        ->join('users as managers', 'managers.id', '=', 'teams.manger_id') // جلب بيانات المدير
        ->where('tasks.member_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
        ->select('managers.*') // استخراج بيانات المدراء فقط
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
        $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('member.task.table' , compact('notifications' ,'task' , 'user' ,'unreadMessagesCount' , 'unreadMessages') );
    }
  
    public function add_document( $id)
    {
        $user = DB::table('tasks')
        ->join('teams', 'teams.id', '=', 'tasks.team_id') // جلب بيانات الفريق
        ->join('users as managers', 'managers.id', '=', 'teams.manger_id') // جلب بيانات المدير
        ->where('tasks.member_id', Auth::user()->id) // البحث عن الفرق التي ينتمي لها المستخدم
        ->select('managers.*') // استخراج بيانات المدراء فقط
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
            $task = Task::find($id);
            $notifications = Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        return view('member.task.add' , compact('notifications' , 'task' , 'user'  ,'unreadMessagesCount' , 'unreadMessages') );
    }
    public function store_document(Request $request)
    {
        $request->validate([
            'document' => 'required|mimes:pdf,docx,pptx',
            'progress_update' => 'required|integer|min:1|max:100'
        ], [
            'document.mimes' => 'The document file must be a PDF, DOCX, or PPTX.',
        ]);
    
        $taskId = $request->input('id');
        $task = Task::findOrFail($taskId);
        $user = Auth::user();
    
        // البحث عن تقرير موجود لنفس المهمة
        $document = Document::where('task_id', $task->id)
                            ->where('member_id', $user->id)
                            ->first();
    
        if (!$document) {
            $document = new Document();
            $document->task_id = $task->id;
            $document->member_id = $user->id;
            $document->team_id = $task->team_id;
        }
    
        // تحديث نسبة التقدم
        $progressUpdate = $request->input('progress_update');
        $document->progress_update = $progressUpdate;
    
        // رفع وتحديث الملف
        if ($request->hasFile('document')) {
            // حذف الملف السابق إن وجد
            if ($document->document) {
                $oldFile = public_path('uploads/document/' . $document->document);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
                }
            }
    
            // حفظ الملف الجديد
            $file = $request->file('document');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/document/'), $filename);
            $document->document = $filename;
        }
    
        $document->save();
    
        // تحديث تقدم المهمة
        $task->progress = min(100, $task->progress + $progressUpdate);
        if ($task->progress >= 100) {
            $task->status = "Implemented"; // المهمة مكتملة
        }

        $task->update();
        ProgressHistory::create([
            'task_id' => $task->id,
            'progress' => $task->progress,
            'recorded_at' => now()
        ]);
    
        return redirect()->route('member.show.task')->with('status', 'Report uploaded and progress updated!');
    }

    public function generate($id)
{
    $team = Team::with(['tasks.member', 'members', 'manger'])->findOrFail($id);

    $pdf = FacadePdf::loadView('manger.group.report', [
        'team' => $team,
        'members' => $team->members,
        'tasks' => $team->tasks
    ]);

    return $pdf->download('project-report-' . $team->project_name . '.pdf');
}
}

