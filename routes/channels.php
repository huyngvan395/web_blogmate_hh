<?php

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::routes(['middleware' => ['auth']]);

Broadcast::channel('conversations.{conversation_id}', function ($user, $conversation_id) {
    return $user->id === Conversation::findOrFail($conversation_id)->sender_id ||
           $user->id === Conversation::findOrFail($conversation_id)->receiver_id;
});

Broadcast::channel('updateChatList.{userID}', function ($user, $userID) {
    return $user->id === $userID;
});

// Broadcast::channel('conversations.{conversation_id}', function ($user){
//     return true;
// });

// Broadcast::channel('conversations.{conversationID}', function ($user, $conversationID) {
//     return Conversation::where('id',$conversationID)
//     ->where( function($query) use ($user){
//         $query->where('sender_id', $user()->id)
//         ->orWhere('receiver_id', $user()->id);
//     })->exists(); 
// });
