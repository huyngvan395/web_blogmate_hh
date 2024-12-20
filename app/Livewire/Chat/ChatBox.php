<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Events\UpdateChatList;
use App\Jobs\DelayMessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatBox extends Component
{
    use WithFileUploads;

    public $selectConversationID;
    public $messages = [];
    public $messagesPaginator;
    public $userTarget;
    public $file;
    public $image;
    public $text;
    public $currentPage;

    public function mount($userTargetID = null)
    {
        // $this->selectConversationID = null;
        if ($userTargetID) {
            $this->dispatch('openChatBox');
            $this->userTarget = User::find($userTargetID);
            $conversation = Conversation::where(function ($query) {
                $query->where('sender_id', $this->userTarget->id)->where('receiver_id', Auth::user()->id);
            })->orWhere(function ($query) {
                $query->where('sender_id', Auth::user()->id)->where('receiver_id', $this->userTarget->id);
            })->first();
            if ($conversation) {
                $this->selectConversationID = $conversation->id;
                $this->dispatch('conversationID', conversationID: $this->selectConversationID);
                $this->loadMessages();
            }
        } else {
            $this->userTarget = null;
        }
    }


    public function updated($propertyName)
    {
        if ($propertyName === 'file' && $this->file !== null) {
            $this->addMessage('file');
        }

        if ($propertyName === 'image' && $this->image !== null) {
            $this->addMessage('image');
        }
    }


    public function render()
    {
        return view('livewire.chat.chat-box');
    }

    public function addMessage($type = 'text')
    {
        $status="";
        if ($this->selectConversationID == null) {
            $conversation = new Conversation();
            $conversation->sender_id = Auth::user()->id;
            $conversation->receiver_id = $this->userTarget->id;
            $conversation->save();
            $this->selectConversation($conversation->id);
            // $this->getListeners();
            $status="first";
        }
        if ($this->file) {
            $path = $this->file->storeAs('images/chat/file', $this->file->getClientOriginalName(), 'public');
            $this->file->delete();
            $type = 'file';
            $message = new Message();
            $message->conversation_id = $this->selectConversationID;
            $message->user_id = Auth::user()->id;
            $message->content = $path;
            $message->type = $type;
            $message->save();
            $this->file = null;
        } else if ($this->image) {
            $path = $this->image->storeAs('images/chat/image', $this->image->getClientOriginalName(), 'public');
            $this->image->delete();
            $type = 'image';
            $message = new Message();
            $message->conversation_id = $this->selectConversationID;
            $message->user_id = Auth::user()->id;
            $message->content = $path;
            $message->type = $type;
            $message->save();
            $this->image = null;
        } else {
            $message = new Message();
            $message->conversation_id = $this->selectConversationID;
            $message->user_id = Auth::user()->id;
            $message->content = $this->text;
            $message->type = $type;
            $message->save();
        }

        if($status=="first"){
            $this->loadMessages();
            $status="";
        }
        // dd($message->id, $this->selectConversationID, Auth::user()->id, $message->content, $type, now()->toDateTimeString());
        MessageSent::dispatch($message->id, $this->selectConversationID, Auth::user()->id, $message->content, $type, now()->toDateTimeString());
        $this->dispatch('updateChatList');
        UpdateChatList::dispatch($this->userTarget->id);
    }

    #[On('selectConversationID')]
    public function selectConversation($conversationID)
    {
        $this->selectConversationID = $conversationID;
        $this->dispatch('conversationID', conversationID: $this->selectConversationID);
        $conversation = Conversation::find($this->selectConversationID);
        if ($conversation->sender_id == Auth::user()->id) {
            $this->userTarget = User::find($conversation->receiver_id);
        } else {
            $this->userTarget = User::find($conversation->sender_id);
        }
        $this->loadMessages();
    }

    public function loadMessages()
    {
        // $this->messages = Message::where('conversation_id', $this->selectConversationID)->get()->toArray();
        $totalPages= ceil(Message::where('conversation_id', $this->selectConversationID)->count() / 7);
        $this->currentPage=$totalPages;
        $this->messages = Message::where('conversation_id', $this->selectConversationID)
                              ->orderBy('created_at', 'asc') 
                              ->paginate( 7 ,['*'], 'page', $totalPages)->items();
                            //   dd($this->messages);
                            //   dd($this->messagesPaginator->items());
        // $this->messages=$this->messagesPaginator->items();
                            //   dd($this->messages);
    }

    public function loadOlderMessages()
    {
        if($this->currentPage> 1){
            $olderMessages=Message::where('conversation_id', $this->selectConversationID)
            ->orderBy('created_at', 'asc') 
            ->paginate(7 ,['*'], 'page', $this->currentPage - 1)->items();
            $this->messages=array_merge($olderMessages, $this->messages);
            $this->currentPage-=1;
            return $this->currentPage> 1;
        }else{
            return false;
        }
    }

    // public function getListeners()
    // {
    //     return [
    //         "echo:conversations.{$this->selectConversationID},MessageSent" => 'onMessage',
    //     ];
    // }

    #[On('updateMessage')]
    public function onMessage($event)
    {
        // [
        //     'id' => $event['id'],
        //     'conversation_id' => $event['conversationID'],
        //     'user_id' => $event['user_id'],
        //     'content' => $event['content'],
        //     'type' => $event['type'],
        //     'created_at' => $event['create_at'],
        // ]
        // dd($event);
        $this->messages[] = $event;
        
    }
}
