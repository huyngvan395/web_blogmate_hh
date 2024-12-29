<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public function conversation()
    {
        return $this->hasMany(Conversation::class);
    }

    public function blog()
    {
        return $this->hasMany(Blog::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function heartBlog()
    {
        return $this->belongsToMany(Blog::class,'hearts','user_id','blog_id');
    }

    public function heartComment()
    {
        return $this->belongsToMany(Comment::class,'hearts_comment','user_id','comment_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')
                    ->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class,'follows','followed_id','follower_id')
                    ->withTimestamps();
    }
}
