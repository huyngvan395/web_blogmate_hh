<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable=[
        'receiver_id',
        'sender_id'
    ];

    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id','id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id','id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }
    
}
