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
use App\ClassStudent;
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
            'verification_code' => 'required',
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

        $code = $request->verification_code;
        $group_id = (int) $request->group;
        $data = $request->all();

        if ( ! VerificationCode::where(['code' => $code, 'group_id' => $group_id, 'status' => 0])->exists())
        {
            $group = Group::findOrFail((int) $group_id);
            $class_section_code = ClassSectionCode::where(['code' => $code, 'status' => 0]);

            if (strtolower($group->name) != 'student' && ! $class_section_code->exists())
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

        $parent_code = $user->id . str_random(10);

        Profile::insert([
            'user_id'       => $user->id,
            'first_name'    => $data['first_name'],
            'middle_name'   => $data['middle_name'],
            'last_name'     => $data['last_name'],
            'gender'        => $data['gender'],
            'birthday'      => $data['birthday'],
            'address'       => $data['address'],
            'parent_code'   => $parent_code
        ]);

        $verification_code = VerificationCode::where('code', $request->verification_code)->first();

        if ($verification_code)
        {
            SchoolMember::create([
                'user_id'       => $user->id,
                'school_id'     => $verification_code->school_id,
                'verification_code_id'=> $verification_code->id,
                'status'        => 1
            ]);

            VerificationCode::findOrFail($verification_code->id)->update(['status' => 1]);
        }
        else
        {

            ClassSectionCode::where('code', $data['verification_code'])->update(['status' => 1]);
            $class_section_code = ClassSectionCode::with('class_section')->where('code', $data['verification_code'])->first();

            SchoolMember::create([
                'user_id'       => $user->id,
                'school_id'     => $class_section_code->class_section->school_id,
                'status'        => 1
            ]);

            ClassStudent::create([
                'class_section_id'  => (int) $class_section_code->class_section_id,
                'class_section_code_id' => (int) $class_section_code->id,
                'student_id'        => $user->id
            ]);

            $user = User::findOrFail($user->id);
            $user->status = 1;
            $user->save();
        }

        return $user;
    }
}
