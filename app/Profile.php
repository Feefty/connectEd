<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'birthday', 'address', 'gender', 'user_id', 'photo', 'parent_code'];
    public $timestamps = false;

    public function user()
    {
    	return $this->belongsTo('\App\User');
    }
}
