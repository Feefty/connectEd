<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupMessage extends Model
{
    protected $table = 'group_messages';
    protected $fillable = ['title', 'created_by'];

    public function user()
    {
        return $this->belongsTo('\App\User', 'created_by');
    }

    public function message()
    {
        return $this->hasMany('\App\Message');
    }
}
