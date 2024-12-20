<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $appends = ['formatted_time'];

    protected $fillable = [
        'user_id',
        'blog_id',
        'content',
        'reply_id'
    ];

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usersWhoHearts()
    {
        return $this->belongsToMany(User::class, 'hearts_comment', 'comment_id', 'user_id');
    }

    public function replyTo()
    {
        return $this->belongsTo(Comment::class, 'reply_id');
    }

    public function reply()
    {
        return $this->hasMany(Comment::class, 'reply_id');
    }

    public function totalReplies()
    {
        return $this->reply->count() + $this->reply->sum(function ($reply) {
            return $reply->totalReplies();
        });
    }

    public function getFormattedTimeAttribute()
    {
        $createdAt = $this->created_at;
        // $diffInMinutes = Carbon::now()->diffInMinutes($createdAt);
        // $diffInHours = Carbon::now()->diffInHours($createdAt);
        // $diffInDays = Carbon::now()->diffInDays($createdAt);
        // $diffInWeeks = Carbon::now()->diffInWeeks($createdAt);
        // $diffInYears = Carbon::now()->diffInYears($createdAt);

        // if ($diffInMinutes < 60) {
        //     return $diffInMinutes . ' phút trước';
        // } elseif ($diffInHours < 24) {
        //     return $diffInHours . ' giờ trước';
        // } elseif ($diffInDays < 7) {
        //     return $diffInDays . ' ngày trước';
        // } elseif ($diffInWeeks < 53) {
        //     return $diffInWeeks . ' tuần trước';
        // } else {
        //     return $diffInYears . ' năm trước';
        // }
        return $createdAt->diffForHumans(Carbon::now());
    }
}
