<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => [
                'required', 
                'regex:/^[a-zA-Zء-ي\s]+$/u', 
                'unique:users',
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
           
            'job' => [  // إضافة شرط حقل job هنا
                'required',
                'unique:users',
                'integer', 
                'regex:/^\d{9}$/'
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
            'job.regex' => 'The job ID must be exactly 9 digits.',
            'job.unique' => 'This job id is already in use.',

        ]);
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
                // التحقق من وجود الصورة
                if (isset($data['image']) && $data['image']) {
                    $file = $data['image'];
                    $extention = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extention;
                    $file->move('uploads/profile/', $filename);
                    $image = $filename;
                } else {
                    $image = null; // تعيين قيمة افتراضية إذا لم تكن الصورة موجودة
                }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'job' => $data['job'],
            'role' => 'manger',
            'image' => $image,
            'password' => Hash::make($data['password']),
        ]);
    }
}
