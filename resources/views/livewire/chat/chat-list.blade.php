<div x-show="openChatList" class="h-full w-full md:w-1/3 xl:w-1/4 overflow-hidden ml-0 sm:p-8 md:p-0 md:ml-5 border-x border-gray-300">
    <form class="flex items-center justify-center mt-4">
        <x-text-input placeholder="Tìm kiếm" class="w-full md:w-5/6 ml-0 md:ml-2" />
        <button type="submit" class="border-none p-2 hover:bg-gray-200 rounded-md"><x-gmdi-search class="w-8 h-8 text-sky-500"/></button>
    </form>
    <div class="overflow-y-scroll overflow-x-hidden h-9/10">
        <div class="flex items-center flex-col">
            @if($conversation_list->isNotEmpty())
            @foreach($conversation_list as $conversation)
            <div wire:click="selectConversation({{$conversation->id}})" class="flex items-center justify-start gap-2 w-full pl-3 py-2 relative hover:bg-gray-300 hover:cursor-pointer">
                @if($conversation->sender_id != Auth::user()->id)
                <div class="flex justify-center items-center">
                    <img src="{{asset('storage/'.$conversation->sender->avatar)}}" class="w-10 h-10 md:w-12 md:h-12 rounded-full" alt="">
                </div>
                <div class="flex flex-col py-2 md:w-3/4 w-10/12">
                    <h1 class="text-xl overflow-hidden">{{$conversation->sender->name}}</h1>
                    <p class="text-lg text-gray-500 overflow-hidden line-clamp-1">
                        @if($conversation->latestMessage->type == 'file')
                            @if($conversation->latestMessage->user_id == Auth::user()->id)
                            Bạn đã gửi một tệp
                            @else
                            {{last(explode(' ', $conversation->latestMessage->user->name))}} đã gửi một tệp
                            @endif
                        @elseif($conversation->latestMessage->type == 'image')
                            @if($conversation->latestMessage->user_id == Auth::user()->id)
                            Bạn đã gửi một ảnh
                            @else
                            {{last(explode(' ', $conversation->latestMessage->user->name))}} đã gửi một ảnh
                            @endif
                        @else
                            @if($conversation->latestMessage->user_id == Auth::user()->id)
                            Bạn: {{$conversation->latestMessage->content}}
                            @else
                            {{last(explode(' ', $conversation->latestMessage->user->name))}}: {{$conversation->latestMessage->content}}
                            @endif
                        @endif
                    </p>
                    <!-- Hiển thị thời gian tin nhắn -->
                    <span class="text-sm text-gray-400">{{$conversation->latestMessage->formatted_time}}</span>
                </div>
                @else
                <div class="flex">
                    <img src="{{asset('storage/'.$conversation->receiver->avatar)}}" class="w-12 h-12 rounded-full" alt="">
                </div>
                <div class="flex flex-grow flex-col py-2">
                    <h1 class="text-xl overflow-hidden">{{$conversation->receiver->name}}</h1>
                    <p class="text-lg text-gray-500 w-72 line-clamp-1 overflow-hidden">
                        @if($conversation->latestMessage->type == 'file')
                            @if($conversation->latestMessage->user_id == Auth::user()->id)
                            Bạn đã gửi một tệp
                            @else
                            {{last(explode(' ', $conversation->latestMessage->user->name))}} đã gửi một tệp
                            @endif
                        @elseif($conversation->latestMessage->type == 'image')
                            @if($conversation->latestMessage->user_id == Auth::user()->id)
                            Bạn đã gửi một ảnh
                            @else
                            {{last(explode(' ', $conversation->latestMessage->user->name))}} đã gửi một ảnh
                            @endif
                        @else
                            @if($conversation->latestMessage->user_id == Auth::user()->id)
                            Bạn: {{$conversation->latestMessage->content}}
                            @else
                            {{last(explode(' ', $conversation->latestMessage->user->name))}}: {{$conversation->latestMessage->content}}
                            @endif
                        @endif
                    </p>
                    <span class="text-sm text-gray-400">{{$conversation->latestMessage->formatted_time}}</span>
                </div>
                @endif
                <button class="absolute top-0 right-0 p-2 hover:bg-gray-200"><x-bi-three-dots class="w-4 h-4"/></button>
            </div>            
            @endforeach
            @else
            <p class="text-center p-6 text-gray-500 text-wrap">Chưa nhắn tin với người dùng nào</p>
            @endif
        </div>

    </div>

</div>
<script>
    window.userID = @json(Auth::user()->id);
</script>