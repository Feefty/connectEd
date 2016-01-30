<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['content', 'from_id', 'to_id', 'group_message_id', 'created_at', 'updated_at'];

    public function to()
    {
        return $this->belongsTo('\App\User', 'to_id');
    }

    public function from()
    {
        return $this->belongsTo('\App\User', 'from_id');
    }

    public function group_message()
    {
        return $this->belongsTo('\App\GroupMessage');
    }
}
