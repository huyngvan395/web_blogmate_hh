<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $appends = ['formatted_time'];

    protected $fillable=[
        'user_id',
        'type',
        'link',
        'userTarget_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getFormattedTimeAttribute()
    {
        $createdAt = $this->created_at;
        return $createdAt->diffForHumans(Carbon::now());
    }
}
