<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laravel\Scout\Searchable;

class Blog extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'image_blog',
        'category_id'
    ];

    protected $appends = ['formatted_time'];

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }

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

        return $created_at->diffForHumans($now);
    }
}
