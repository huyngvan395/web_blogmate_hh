<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'image_blog',
        'category_id'
    ];

    protected $appends = ['formatted_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function usersWhoHearts()
    {
        return $this->belongsToMany(User::class, 'hearts', 'blog_id', 'user_id');
    }

    /**
     *
     * @return string
     */
    public function getFormattedTimeAttribute()
    {
        $created_at = Carbon::parse($this->created_at); 
        $now = Carbon::now();

        if ($created_at->isToday()) {
            $diffInMinutes = $created_at->diffInMinutes($now);
            if ($diffInMinutes < 60) {
                return $created_at->diffForHumans();
            }

            $diffInHours = $created_at->diffInHours($now);
            if ($diffInHours < 24) {
                return $diffInHours . ' giờ trước';
            }
        }

        if ($created_at->isYesterday()) {
            return 'Hôm qua lúc ' . $created_at->format('H:i');
        }

        return $created_at->format('d/m/Y H:i'); 
    }
}
