<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $appends = ['formatted_time'];

    protected $fillable = [
        'conversation_id',
        'user_id',
        'type',
        'content',
        'read_at',
        'receiver_deleted_at',
        'sender_deleted_at',
    ];

    protected $dates = ['read_at', 'receiver_deleted_at', 'sender_deleted_at'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFormattedTimeAttribute()
    {
        $createdAt = $this->created_at;

        if ($createdAt->isToday()) {
            return 'Hôm nay lúc ' . $createdAt->format('H:i');
        } elseif ($createdAt->isYesterday()) {
            return 'Hôm qua lúc ' . $createdAt->format('H:i');
        } elseif ($createdAt->isSameWeek(Carbon::now())) {
            return ucfirst($createdAt->translatedFormat('l \l\ú\c H:i'));
        } else {
            return $createdAt->format('H:i d/m/Y');
        }
    }
}
