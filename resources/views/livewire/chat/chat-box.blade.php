<div x-show="openChatBox" class="h-full flex flex-col w-full md:w-2/3 xl:w-3/4 mr-0 md:mr-5 border-x border-gray-300">
    @if($userTarget !=null)
    <div class="flex items-center p-2 gap-2 border-b-2 z-20 md:relative">
        <button @click="openChatBox= !openChatBox ; openChatList= !openChatList"
            class="flex md:hidden justify-center items-center p-2 pr-4">
            <x-heroicon-o-chevron-left class="w-5 h-5" />
        </button>
        <img src="{{asset('storage/'.$userTarget->avatar)}}" class="h-10 w-10 rounded-full" alt="">
        <h1 class="text-xl">{{$userTarget->name}}</h1>
    </div>
    <div class="overflow-y-scroll chatbox flex-grow" 
    x-data="{ scrollTop: 0, isLoading:false, scrollHeight: 0, isAtTop: false ,hasMoreMessages: true,
                handleScroll() {
                if (this.isLoading || !this.hasMoreMessages) return; 
                this.scrollTop = $el.scrollTop;
                this.isAtTop = this.scrollTop === 0;

                if (this.isAtTop) {
                    this.isLoading = true;
                    @this.call('loadOlderMessages').then((hasMore) => {
                        this.isLoading = false;
                        this.hasMoreMessages = hasMore;
                        $el.scrollTop = $el.scrollHeight - this.scrollHeight;
                        this.scrollHeight = $el.scrollHeight;
                    });
                } else {
                    this.scrollHeight = $el.scrollHeight;
                }
                }
            }" 
    x-init="() => {
        $el.addEventListener('scroll', () => handleScroll());
    }">
        <div x-show="isLoading" class="w-full flex justify-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-mainColor1"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
        @if(!empty($messages))
        @foreach($messages as $message)
        <div class="">
            @if($message['type'] == 'text')
                @if($message['user_id'] != Auth::user()->id)
                <div class="flex justify-start py-2 pl-5">
                    <div class="flex flex-col items-start w-full">
                        <p class="max-w-9/10 md:max-w-65/100 p-2 rounded-md bg-gray-300">{{$message['content']}}</p>
                        <span class="text-sm text-gray-400">{{$message['formatted_time']}}</span>
                    </div>
                </div>
                @else
                <div class="flex justify-end py-2 px-1">
                    <div class="flex flex-col items-end w-full">
                        <p class="max-w-9/10 md:max-w-65/100 p-2 rounded-md text-white bg-mainColor1">{{$message['content']}}
                        </p>
                        <span class="text-sm text-gray-400">{{$message['formatted_time']}}</span>
                    </div>
                </div>
                @endif
            @elseif($message['type'] == 'file')
                @if($message['user_id'] != Auth::user()->id)
                <div class="flex justify-start">
                    <div class="flex flex-col justify-start px-2 items-center">
                        <h1 class="bg-amber-300 p-2 text-lg text-gray-400">{{basename($message['content'])}}</h1>
                        <span class="text-sm text-gray-400 pl-2">{{$message['formatted_time']}}</span>
                    </div>
                </div>
                @else
                <div class="flex justify-end">
                    <div class="flex flex-col justify-end px-2 items-center">
                        <h1 class="bg-amber-300 p-2 text-lg text-gray-400">{{basename($message['content'])}}</h1>
                        <span class="text-sm text-gray-400 pl-2">{{$message['formatted_time']}}</span>
                    </div>
                </div>
                @endif
            @else
                @if($message['user_id'] != Auth::user()->id)
                <div class="flex justify-start py-2 px-1">
                    <div>
                        <img src="{{asset('storage/'.$message['content'])}}" class="w-72 h-60 rounded-md" alt="">
                        <span class="text-sm text-gray-400">{{$message['formatted_time']}}</span>
                    </div>
                </div>
                @else
                <div class="flex justify-end py-2 px-1">
                    <div>
                        <img src="{{asset('storage/'.$message['content'])}}" class="w-72 h-60 rounded-md" alt="">
                        <span class="text-sm text-gray-400">{{$message['formatted_time']}}</span>
                    </div>
                </div>
                @endif
            @endif
        </div>
        @endforeach
        @else
        <div class="flex justify-center items-center">
            <p class="text-center pt-10 text-gray-500">Hãy bắt đầu chat với {{$userTarget->name}}</p>
        </div>
        @endif
    </div>
    <div class="flex justify-center items-center">
        <div class="px-1 sm:px-3">
            <label class="block w-auto h-auto p-0 sm:p-2 rounded-md hover:bg-gray-200 hover:cursor-pointer">
                <x-gmdi-attach-file-r class="w-8 h-8 text-mainColor1" />
                <input type="file" class="hidden" wire:model="file" />
            </label>
        </div>
        <div class="px-1 sm:px-3">
            <label class="block w-auto h-auto p-0 sm:p-2 rounded-md hover:bg-gray-200 hover:cursor-pointer">
                <x-carbon-image class="w-8 h-8 text-mainColor1" />
                <input type="file" class="hidden" wire:model="image" />
            </label>
        </div>
        <form wire:submit='addMessage' class="flex items-center flex-grow px-3 mb-2">
            <textarea x-ref="textarea" wire:model='text'
                class="flex-grow py-2 h- resize-none border-gray-300 focus:border-mainColor1 focus:ring-mainColor1_300 rounded-md shadow-sm overflow-hidden"
                placeholder="Nhập tin nhắn ở đây"
                :style="'height:' + textareaHeight + 'px; max-height:' + maxHeight + 'px; '" @input="textareaHeight = $refs.textarea.scrollHeight > maxHeight ? maxHeight : $refs.textarea.scrollHeight;
                if ($refs.textarea.value === '') {
                    textareaHeight = minHeight;
                }" @keydown="
                if($event.key === 'Backspace' || $event.key === 'Delete') {
                    textareaHeight = $refs.textarea.scrollHeight > minHeight ? $refs.textarea.scrollHeight : minHeight;
                }
                if($event.key === 'Enter'){
                    $event.preventDefault();
                    $refs.submitBtn.click();
                    $refs.textarea.value = '';
                    textareaHeight=minHeight;
                }
              "></textarea>
            <button type='submit' x-ref='submitBtn' @click="textareaHeight=minHeight;$refs.textarea.value = '';"
                class="flex border-none justify-center items-center p-2 rounded-md hover:bg-gray-200 hover:cursor-pointer">
                <x-carbon-send-filled class="w-8 h-8 text-mainColor1  " />
            </button>
        </form>
    </div>
    @else
    <div class="flex h-full w-full justify-center items-center">
        <h1 class="text-wrap text-gray-500">Hãy chọn đoạn hội thoại để bắt đầu chat nào</h1>
    </div>
    @endif
</div>
