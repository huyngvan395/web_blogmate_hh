<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ChatList extends Component
{
    public $conversation_list;
    public $searchTerm="";

    public function mount()
    {
        $this->conversation_list = Conversation::where('sender_id', Auth::user()->id)->orWhere('receiver_id', Auth::user()->id)->get();
    }

    public function selectConversation($conversationID)
    {
        Message::where('conversation_id', $conversationID)
        ->where('user_id', '!=', Auth::user()->id)
        ->whereNull('read_at')
        ->update(['read_at' => now()]);
        $this->dispatch('selectConversationID', conversationID: $conversationID);
        $this->dispatch('openChatBox');
    }

    public function updatedSearchTerm($value)
    {
        $this->fetchConversations();
    }

    private function fetchConversations()
    {
        if (empty($this->searchTerm)) {
            $this->conversation_list = Conversation::where('sender_id', Auth::id())
                ->orWhere('receiver_id', Auth::id())
                ->with(['sender', 'receiver', 'latestMessage'])
                ->get()->sortByDesc(function ($conversation) {
                    return $conversation->latestMessage->created_at;
                });;
        } else {
            $this->conversation_list = Conversation::search($this->searchTerm)
                ->get()
                ->filter(function ($conversation) {
                    return $conversation->sender_id === Auth::id() || $conversation->receiver_id === Auth::id();
                });
        }
    }

    #[On('updateChatList')]
    public function updateChatList()
    {
        $this->conversation_list= $this->conversation_list = Conversation::with(['latestMessage'])
        ->where(function ($query) {
            $query->where('sender_id', Auth::user()->id)
                  ->orWhere('receiver_id', Auth::user()->id);
        })
        ->get()
        ->sortByDesc(function ($conversation) {
            return $conversation->latestMessage->created_at;
        });
    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}


