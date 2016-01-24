<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Profile;
use App\Group;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use App\VerificationCode;
use App\SchoolMember;
use App\ClassSectionCode;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $username = 'username';
    protected $loginPath = 'login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'username' => 'required|max:25|unique:users|alpha_num',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'first_name' => 'required|max:150',
            'last_name' => 'required|max:150',
            'middle_name' => 'max:150',
            'gender' => 'required',
            'birthday' => 'required|date',
            'address' => 'max:255',
            'school_code' => 'required|exists:school_codes,code'
        ]);

        return $validator;
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $code = $request->school_code;
        $group_id = (int) $request->group;
        
        if ( ! VerificationCode::where(['code' => $code, 'group_id' => $group_id, 'status' => 0])->exists())
        {
            $group = Group::findOrFail((int) $group_id);
            $class_section_code = ClassSectionCode::where(['code' => $code, 'status' => 0]);
            if (strtolower($group->name) == 'student' && 
                $class_section_code->exists())
            {
                $class_section_code = $class_section_code->first();
                ClassSectionCode::where('code', $code)->update(['status' => 1]);
                ClassStudent::create([
                    'class_section_id'  => (int) $class_section_code->class_section_id,
                    'class_section_code_id' => $code,
                    'student_id'        => (int) $request->user()->id
                ]);
            }
            else
            {
                return redirect()->back()->withErrors("Invalid membership code.");
            }
        }


        Auth::login($this->create($request->all(), $request));

        return redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data, $request)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'group_id' => (int) $data['group'],
            'status' => config('auth.status')
        ]);

        Profile::insert([
            'user_id'       => $user->id,
            'first_name'    => $data['first_name'],
            'middle_name'   => $data['middle_name'],
            'last_name'     => $data['last_name'],
            'gender'        => $data['gender'],
            'birthday'      => $data['birthday'],
            'address'       => $data['address']
        ]);

        $school_code = VerificationCode::where('code', $request->school_code)->first();

        SchoolMember::create([
            'user_id'       => $user->id,
            'school_id'     => $school_code->school_id,
            'school_code_id'=> $school_code->id,
            'status'        => 1
        ]);

        VerificationCode::findOrFail($school_code->id)->update(['status' => 1]);

        return $user;
    }
}
