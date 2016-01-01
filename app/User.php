<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'email', 'password', 'group_id', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function profile()
    {
        return $this->hasOne('\App\Profile');
    }

    public function class_section()
    {
        return $this->hasOne('\App\ClassSection', 'teacher_id');
    }

    public function class_student()
    {
        return $this->hasOne('\App\ClassStudent', 'student_id');
    }

    public function school_member()
    {
        return $this->hasOne('\App\SchoolMember');
    }

    public function group()
    {
        return $this->belongsTo('\App\Group');
    }

    public function student_exam_question_answer()
    {
        return $this->hasMany('\App\StudentExamQuestionAnswer');
    }
}
