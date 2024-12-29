<x-app-layout>
    <x-slot name="slot">
        <div x-data="dataBlogDetail">
            <div class="mt-24 mx-1 sm:mx-4 md:mx-10 xl:mx-80">
                <div class="px-2 py-8">
                    <h1 class="text-3xl md:text-5xl font-bold">{{$blog->title}}</h1>
                </div>
                {{-- Information author --}}
                <div class="flex py-5">
                    {{-- image avatar --}}
                    <div class="flex justify-center items-center">
                        <a href="{{route('user.info',['infoUser'=> Str::before($blog->user->email, '@') ])}}">
                            <img src="{{asset('storage/'.$blog->user->avatar)}}"
                                class="w-10 h-10 hover:opacity-60 rounded-full" alt="">
                        </a>
                    </div>
                    {{-- info --}}
                    <div class="flex flex-col pl-3">
                        <div class="flex">
                            <a href="{{route('user.info',['infoUser'=> Str::before($blog->user->email, '@') ])}}">
                                <h1 class="hover:underline">{{$blog->user->name}}</h1>
                            </a>
                            <span class="inline-block px-2">.</span>
                            @if($blog->user->id!=auth()->user()->id)
                            <button x-show="!followed" @click="follow()" id="follow"
                                class="bg-transparent text-sky-500">Theo dõi</button>
                            <button x-show="followed" @click="follow()" id="following"
                                class="bg-transparent text-sky-500">Đang theo dõi</button>
                            @endif
                        </div>
                        <p class="text-gray-500">{{$blog->formatted_time}}</p>
                    </div>
                </div>
                {{-- Contact with blog --}}
                <div class="border-y  py-2 border-gray-300 flex relative">
                    {{-- hearts --}}
                    <div class="flex justify-center items-center pl-2">
                        <button @click="heart(); hearted= !hearted;">
                            <template x-if="hearted">
                                <x-heroicon-s-heart id="sHeart" class="text-sky-500 w-7 h-7 hover:-translate-y-1" />
                            </template>
                            <template x-if="!hearted">
                                <x-heroicon-s-heart id="oHeart" class="text-gray-400 w-7 h-7 hover:-translate-y-1" />
                            </template>
                        </button>
                        <button @click="showListUserHeart= !showListUserHeart" id="users-heart-count"
                            class="text-gray-400 hover:text-gray-800" x-text="heartCount"></button>
                    </div>
                    {{-- comments --}}
                    <div class="flex px-4 ">
                        <button @click="showListUserComment= !showListUserComment" name="comment" id="comment"
                            class="flex text-gray-400 justify-center items-center hover:text-gray-800">
                            <x-gmdi-mode-comment-s class="fill-current w-7 h-7" />
                            <p x-text="commentCount"></p>
                        </button>
                    </div>
                    {{-- more options --}}
                    <div class="flex justify-end items-center flex-grow pr-3">
                        <button class="hover:bg-gray-200" @click="showMoreOption= !showMoreOption; console.log('Thành công')">
                            <x-bi-three-dots class="text-gray-400 w-5 h-5" />
                        </button>
                    </div>
                    <div x-cloak x-show="showMoreOption" class="absolute -bottom-8 right-0 border rounded-md bg-white">
                        @if(Auth::user()->id == $blog->user->id)
                        <div class="flex justify-center items-center">
                            <div @click="deleteBlog({{$blog->id}})" class="flex justify-center items-center hover:cursor-pointer hover:bg-gray-100 p-2">
                                <x-heroicon-s-trash class="w-4 h-4 text-red-500"/>
                                <p class="text-red-500">Xóa bài viết</p>
                            </div>
                        </div>
                        @else 
                        <div class="flex justify-center items-center">
                            <div class="flex justify-center items-center hover:cursor-pointer hover:bg-gray-100 p-2">
                                <x-heroicon-s-flag class="w-4 h-4 text-gray-500"/>
                                <p class="text-gray-500">Báo cáo</p>
                            </div>
                        </div>
                        @endif  
                    </div>
                </div>
                {{-- blog-content --}}
                <div class="trix-content my-6">
                    {!!$blog->content!!}
                </div>
                {{-- more from author --}}
                @if($blog->user->id != Auth::user()->id)
                <div class="border-t  border-gray-400">
                    @if($othersBlog->isNotEmpty())
                    <h1 class="block py-5 text-xl font-extrabold">Nhiều hơn từ {{$blog->user->name}}</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($othersBlog as $otherBlog)
                        {{-- card-blog --}}
                        <div data-id="{{Crypt::encryptString($otherBlog->id)}}" onclick="directToBlogDetail(this)" class="block shadow-md rounded-lg hover:cursor-pointer">
                            <div class="flex flex-col gap-3 justify-center items-center p-4">
                                {{-- image --}}
                                <div class="flex justify-center w-full overflow-hidden rounded-md h-52 ">
                                    <div class="flex justify-center w-full">
                                        <img src="{{$otherBlog->image_blog}}"
                                            class="w-full object-cover rounded-md transition-all hover:scale-110"
                                            alt="">
                                    </div>
                                </div>
                                {{-- info_author --}}
                                <div class="flex gap-2 justify-start items-center w-full">
                                    <div class="flex justify-center items-center">
                                        <img src="{{asset('storage/'.$otherBlog->user->avatar) }}"
                                            class="w-10 h-10 hover:opacity-60 rounded-full" alt="">
                                    </div>
                                    <div class="flex">
                                        <h1 class="hover:underline">{{$otherBlog->user->name}}</h1>
                                    </div>
                                </div>
                                {{-- title --}}
                                <div class="flex justify-start w-full pr-4">
                                    <h1
                                        class="text-2xl truncate line-clamp-2 font-extrabold  text-wrap hover:underline">
                                        {{$otherBlog->title}}</h1>
                                </div>
                                {{-- info contact --}}
                                <div class="flex w-full relative">
                                    <div class="flex">
                                        <div class="text-gray-400 text-lg">
                                            {{$otherBlog->create_at}}
                                        </div>
                                        {{-- hearts --}}
                                        <div class="flex justify-center items-center pl-2">
                                            <button>
                                                <x-heroicon-s-heart class="text-gray-400 w-5 h-5" />
                                            </button>
                                            <button id="users-heart-count"
                                                class="text-gray-400">{{$otherBlog->usersWhoHearts->count()}}</button>
                                        </div>
                                        {{-- comments --}}
                                        <div class="flex px-4">
                                            <button name="comment" id="comment"
                                                class="flex text-gray-400 justify-center items-center">
                                                <x-gmdi-mode-comment-s class="fill-current w-5 h-5" />
                                                {{$otherBlog->comment->count()}}
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </d>
                        @endforeach
                    </div>
                    @if($blog->user->blog->count() >4)
                    <div class="flex justify-center items-center">
                        <a href="{{route('user.info', ['infoUser' => Str::before($blog->user->email), '@'])}}"
                            class="text-sky-500 hover:underline">Xem thêm</a>
                    </div>
                    @endif

                    @else
                    <h1 class="text-center block py-5 text-xl font-extrabold">
                        Không còn bài viết nào khác từ {{$blog->user->name}}
                    </h1>
                    @endif
                </div>
                @endif
            </div>
            {{-- List user heart --}}
            <div x-cloak x-show='showListUserHeart'
                class="fixed inset-0 flex h-screen w-screen bg-opacity-90 bg-white z-50 "
                x-effect="document.body.style.overflow = showListUserHeart ? 'hidden' : ''">
                <div class="fixed top-16 right-16">
                    <button @click="showListUserHeart= !showListUserHeart">
                        <x-heroicon-c-x-mark class="block size-8" />
                    </button>
                </div>
                <div class="flex w-full flex-col justify-start items-center mt-10 ">
                    <h1 class="text-2xl p-5">Danh sách người thả tim</h1>
                    <div class="flex w-full flex-col items-center gap-10 overflow-y-scroll">
                        <template x-for="user in usersWhoHearts" :key="user.id">
                            {{-- user heart --}}
                            <div class="flex justify-between md:w-1/3 sm:w-3/4 w-full ">
                                <div class="flex justify-center items-center gap-2">
                                    <div class="flex justify-center items-center relative">
                                        <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', user.email.split('@')[0])" class="block"><img
                                                :src="'{{ asset('storage/') }}' + '/' + user.avatar"
                                                class="w-10 h-10 hover:opacity-60 rounded-full" alt="Ảnh đại diện">
                                        </a>
                                        <div class="absolute -right-1 bottom-0">
                                            <x-heroicon-s-heart class="text-sky-500 w-5 h-5 " />
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', user.email.split('@')[0])">
                                            <h1 class="hover:underline" x-text="user.name"></h1>
                                        </a>
                                    </div>
                                </div>
                                <template x-if="user.id != {{Auth::user()->id}}">
                                    <div class="flex justify-center items-center">
                                        <button
                                            class=" flex justify-center items-center bg-sky-500 text-white p-2 rounded-2xl">Theo
                                            dõi</button>
                                        <button
                                            class=" hidden justify-center items-center text-sky-500 border border-sky-500 p-2 rounded-2xl">Đang
                                            theo dõi</button>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- List user comment --}}
            <div x-show='showListUserComment' x-cloak
                class="fixed w-full flex justify-center items-center inset-0 h-screen bg-opacity-0 bg-white z-50 "
                x-effect="document.body.style.overflow = showListUserComment ? 'hidden' : ''">
                <div class="h-auto w-1/2 bg-white shadow-md rounded-md relative">
                    <div class="absolute top-8 right-8">
                        <button @click="showListUserComment= !showListUserComment">
                            <x-heroicon-c-x-mark class="block size-8" />
                        </button>
                    </div>
                    <div class="flex flex-col justify-start items-center mt-4 ">
                        <h1 class="text-2xl p-5">Bình luận</h1>
                        <div x-ref="scrollCommentBox" @scroll="handleScroll()"
                            class="w-full mt-4 h-96 overflow-y-scroll">
                            <template x-for="comment in comments" :key="comment.id">
                                <div x-data="processComment(comment.id,comment.hearted_by_current_user, comment.hearted_count)"
                                    class="flex flex-col justify-between items-center px-2 py-2">
                                    <div class="flex flex-col w-full">
                                        <div class="flex items-start w-full">
                                            <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', comment.user.email.split('@')[0])" class="block">
                                                <img :src="'{{ asset('storage/') }}' + '/' + comment.user.avatar"
                                                class="w-10 h-10 rounded-full mr-3" />
                                            </a>
                                            <div class="p-2 bg-gray-200 rounded-md">
                                                <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', comment.user.email.split('@')[0])" class="block">
                                                    <p x-text="comment.user.name" class="font-bold hover:underline"></p>
                                                </a>
                                                <p x-text="comment.content" class="text-gray-600"></p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 justify-start items-center w-full pl-12 pt-1">
                                            <button class="hover:cursor-pointer h-full flex items-center"
                                                @click="heartComment(comment.id);heartedComment=!heartedComment">
                                                <template x-if="heartedComment">
                                                    <x-heroicon-s-heart id="sHeart" class="text-sky-500 w-5 h-5 " />
                                                </template>
                                                <template x-if="!heartedComment">
                                                    <x-heroicon-s-heart id="oHeart" class="text-gray-400 w-5 h-5 " />
                                                </template>
                                            </button>
                                            <p class="hover:underline hover:cursor-pointer text-gray-400"
                                                @click="replyComment=!replyComment">
                                                Trả lời
                                            </p>
                                            <p
                                                class="text-gray-400 flex justify-center items-center border rounded-md px-1">
                                                <span x-text="heartCommentCount"></span>
                                                <x-heroicon-s-heart id="sHeart" class=" w-3 h-3 " />
                                            </p>
                                            <p class="text-gray-400" x-text="comment.formatted_time">
                                            </p>
                                        </div>
                                    </div>
                                    <div x-cloak x-show="replyComment" class="flex w-full box-content">
                                        <form
                                            x-data="{ newComment: '', textareaHeight: 40, maxHeight: 150, minHeight: 40 }"
                                            x-init="textareaHeight = minHeight"
                                            @submit="e=>{e.preventDefault(); commentReply(comment.id); replyComment=!replyComment;}"
                                            class="relative box-border bottom-0 w-full flex items-center flex-grow px-3 ml-12 border-l-2 border-gray-400 pb-2 z-50 bg-white">
                                            <textarea x-ref="textarea" x-model='newComment'
                                                class="flex-grow py-2 h- resize-none border-gray-300 focus:border-sky-500 focus:ring-sky-400 rounded-md shadow-sm overflow-hidden"
                                                :placeholder="'Trả lời bình luận '+ comment.user.name"
                                                :style="'height:' + textareaHeight + 'px; max-height:' + maxHeight + 'px; '"
                                                @input="textareaHeight = $refs.textarea.scrollHeight > maxHeight ? maxHeight : $refs.textarea.scrollHeight;
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
                                                ">
                                            </textarea>
                                            <button type='submit' x-ref='submitBtn'
                                                @click="textareaHeight=minHeight;$refs.textarea.value = '';"
                                                class="flex border-none justify-center items-center p-2 rounded-md hover:bg-gray-200 hover:cursor-pointer">
                                                <x-carbon-send-filled class="w-8 h-8 text-sky-500  " />
                                            </button>
                                        </form>
                                    </div>
                                    {{-- reply comment temporary --}}
                                    <div class="w-full pl-12" x-show="showRepliesTemporary">
                                        <template x-for="reply in repliesList" :key="reply.id">
                                            <div x-data="processComment(reply.id, reply.hearted_by_current_user, reply.hearted_count)"
                                                class="flex flex-col border-l-2 border-gray-400 w-full justify-start items-start px-2 py-2">
                                                <div class="flex flex-col">
                                                    <div class="flex items-start w-full">
                                                        <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', reply.user.email.split('@')[0])" class="block">
                                                            <img :src="'{{ asset('storage/') }}' + '/' + reply.user.avatar"
                                                            class="w-10 h-10 rounded-full mr-3" />
                                                        </a>
                                                        <div class="p-2 bg-gray-200 rounded-md">
                                                            <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', reply.user.email.split('@')[0])" class="block">
                                                                <p x-text="reply.user.name" class="font-bold hover:underline"></p>
                                                            </a>
                                                            <p x-text="reply.content" class="text-gray-600"></p>
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-2 justify-start items-center w-full pl-12 pt-1">
                                                        <button class="hover:cursor-pointer flex items-center h-full"
                                                            @click="heartComment(reply.id);heartedComment=!heartedComment">
                                                            <template x-if="heartedComment">
                                                                <x-heroicon-s-heart id="sHeart"
                                                                    class="text-sky-500 w-5 h-5 " />
                                                            </template>
                                                            <template x-if="!heartedComment">
                                                                <x-heroicon-s-heart id="oHeart"
                                                                    class="text-gray-400 w-5 h-5 " />
                                                            </template>
                                                        </button>
                                                        <p class="hover:underline hover:cursor-pointer text-gray-400"
                                                            @click="replyComment=!replyComment">
                                                            Trả lời
                                                        </p>
                                                        <p class="text-gray-400 flex justify-center items-center border rounded-md px-1">
                                                            <span x-text="heartCommentCount"></span>
                                                            <x-heroicon-s-heart id="sHeart" class=" w-3 h-3 " />
                                                        </p>
                                                        <p class="text-gray-400" x-text="reply.formatted_time">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div x-cloak x-show="replyComment" class="flex w-full box-content">
                                                    <form
                                                        x-data="{ newComment: '', textareaHeight: 40, maxHeight: 150, minHeight: 40 }"
                                                        x-init="textareaHeight = minHeight"
                                                        @submit="e=>{e.preventDefault(); commentReply(reply.id); replyComment=!replyComment}"
                                                        class="relative box-border bottom-0 w-full flex items-center flex-grow px-3 ml-12 border-l-2 border-gray-400 pb-2 z-50 bg-white">
                                                        <textarea x-ref="textarea" x-model='newComment'
                                                            class="flex-grow py-2 resize-none border-gray-300 focus:border-sky-500 focus:ring-sky-400 rounded-md shadow-sm overflow-hidden"
                                                            :placeholder="'Trả lời bình luận '+ reply.user.name"
                                                            :style="'height:' + textareaHeight + 'px; max-height:' + maxHeight + 'px; '"
                                                            @input="textareaHeight = $refs.textarea.scrollHeight > maxHeight ? maxHeight : $refs.textarea.scrollHeight;
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
                                                            ">
                                                        </textarea>
                                                        <button type='submit' x-ref='submitBtn'
                                                            @click="textareaHeight=minHeight;$refs.textarea.value = '';"
                                                            class="flex border-none justify-center items-center p-2 rounded-md hover:bg-gray-200 hover:cursor-pointer">
                                                            <x-carbon-send-filled class="w-8 h-8 text-sky-500  " />
                                                        </button>
                                                    </form>
                                                </div>
                                                <div x-html="renderReplies(reply)"></div>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="w-full pl-12" x-show="!showReplies">
                                        <template x-if="comment.replies_count > 0">
                                            <div class="border-l-2 border-gray-400 pl-2 text-gray-400 ">
                                                <p @click="fetchReplies(comment.id)"
                                                    class="hover:underline hover:cursor-pointer">
                                                    Xem <span x-text="comment.replies_count"></span> câu trả lời</p>
                                            </div>
                                        </template>
                                    </div>
                                    {{-- reply comment --}}
                                    <div class="w-full pl-12" x-show="showReplies">
                                        <template x-for="reply in repliesList" :key="reply.id">
                                            <div x-data="processComment(reply.id, reply.hearted_by_current_user, reply.hearted_count)"
                                                class="flex flex-col border-l-2 border-gray-400 w-full justify-start items-start px-2 py-2">
                                                <div class="flex flex-col">
                                                    <div class="flex items-start w-full">
                                                        <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', reply.user.email.split('@')[0])" class="block">
                                                            <img :src="'{{ asset('storage/') }}' + '/' + reply.user.avatar"
                                                            class="w-10 h-10 rounded-full mr-3" />
                                                        </a>
                                                        <div class="p-2 bg-gray-200 rounded-md">
                                                            <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', reply.user.email.split('@')[0])" class="block">
                                                                <p x-text="reply.user.name" class="font-bold hover:underline"></p>
                                                            </a>
                                                            <p x-text="reply.content" class="text-gray-600"></p>
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-2 justify-start items-center w-full pl-12 pt-1">
                                                        <button class="hover:cursor-pointer flex items-center h-full"
                                                            @click="heartComment(reply.id);heartedComment=!heartedComment">
                                                            <template x-if="heartedComment">
                                                                <x-heroicon-s-heart id="sHeart"
                                                                    class="text-sky-500 w-5 h-5 " />
                                                            </template>
                                                            <template x-if="!heartedComment">
                                                                <x-heroicon-s-heart id="oHeart"
                                                                    class="text-gray-400 w-5 h-5 " />
                                                            </template>
                                                        </button>
                                                        <p class="hover:underline hover:cursor-pointer text-gray-400"
                                                            @click="replyComment=!replyComment">
                                                            Trả lời
                                                        </p>
                                                        <p class="text-gray-400 flex justify-center items-center border rounded-md px-1">
                                                            <span x-text="heartCommentCount"></span>
                                                            <x-heroicon-s-heart id="sHeart" class=" w-3 h-3 " />
                                                        </p>
                                                        <p class="text-gray-400" x-text="comment.formatted_time">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div x-cloak x-show="replyComment" class="flex w-full box-content">
                                                    <form
                                                        x-data="{ newComment: '', textareaHeight: 40, maxHeight: 150, minHeight: 40 }"
                                                        x-init="textareaHeight = minHeight"
                                                        @submit="e=>{e.preventDefault(); commentReply(reply.id); replyComment=!replyComment;}"
                                                        class="relative box-border bottom-0 w-full flex items-center flex-grow px-3 ml-12 border-l-2 border-gray-400 pb-2 z-50 bg-white">
                                                        <textarea x-ref="textarea" x-model='newComment'
                                                            class="flex-grow py-2 resize-none border-gray-300 focus:border-sky-500 focus:ring-sky-400 rounded-md shadow-sm overflow-hidden"
                                                            :placeholder="'Trả lời bình luận '+ reply.user.name"
                                                            :style="'height:' + textareaHeight + 'px; max-height:' + maxHeight + 'px; '"
                                                            @input="textareaHeight = $refs.textarea.scrollHeight > maxHeight ? maxHeight : $refs.textarea.scrollHeight;
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
                                                            ">
                                                        </textarea>
                                                        <button type='submit' x-ref='submitBtn'
                                                            @click="textareaHeight=minHeight;$refs.textarea.value = '';"
                                                            class="flex border-none justify-center items-center p-2 rounded-md hover:bg-gray-200 hover:cursor-pointer">
                                                            <x-carbon-send-filled class="w-8 h-8 text-sky-500  " />
                                                        </button>
                                                    </form>
                                                </div>
                                                <div x-html="renderReplies(reply)"></div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>
                            <div x-show="isLoading" class="w-full flex justify-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-sky-500"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <form x-data="{ newComment: '', textareaHeight: 40, maxHeight: 150, minHeight: 40 }"
                        x-init="textareaHeight = minHeight" @submit="e=>{e.preventDefault(); comment()}"
                        class="relative bottom-0 w-full flex items-center flex-grow px-3 pb-2 z-50 bg-white">
                        <textarea x-ref="textarea" x-model='newComment'
                            class="flex-grow py-2 h- resize-none border-gray-300 focus:border-sky-500 focus:ring-sky-400 rounded-md shadow-sm overflow-hidden"
                            placeholder="Hãy viết bình luận ..."
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
                            ">
                        </textarea>
                        <button type='submit' x-ref='submitBtn'
                            @click="textareaHeight=minHeight;$refs.textarea.value = '';"
                            class="flex border-none justify-center items-center p-2 rounded-md hover:bg-gray-200 hover:cursor-pointer">
                            <x-carbon-send-filled class="w-8 h-8 text-sky-500  " />
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <script>
            function directToBlogDetail(element){
                const hash_id= element.getAttribute('data-id'); 
                window.location.href=`{{route('blog.blog-detail', ['id'=> '__ID__'])}}`.replace('__ID__', hash_id);
            }
            document.addEventListener('alpine:init', () => {
                Alpine.data('dataBlogDetail', () => ({
                    showListUserHeart : false, 
                    showListUserComment : false, 
                    showMoreOption: false,
                    followed: {{ $blog->user->followers->contains(Auth::user()->id) ? 'true' : 'false'}} ,
                    hearted: {{ $blog->usersWhoHearts->contains(Auth::user()->id) ? 'true' : 'false' }} ,
                    heartCount: {{ $blog->usersWhoHearts->count() }} ,
                    commentCount: {{ $commentCount}},
                    usersWhoHearts: [],
                    newComment: '', // Dữ liệu mới cho bình luận
                    comments: [], 
                    isLoading: false,
                    page:1,
                    hasMoreComments: true,
                    init(){
                        this.usersWhoHearts= @json($blog->usersWhoHearts);
                        this.comments=@json($blog->comment);
                        console.log(this.usersWhoHearts);
                        console.log(this.comments);
                    },
                    deleteBlog(id){
                        axios.post("/blog/destroy",{
                            id:id 
                        },{
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                        })
                        .then((response)=>{
                            console.log(response.data.msg);
                            alert('Xóa bài viết thành công');
                            window.location.href=response.data.redirect;
                        })
                    },
                    handleScroll(){
                        const target=this.$refs.scrollCommentBox;
                        if (target.scrollTop + target.clientHeight >= target.scrollHeight) {
                            this.loadMoreComments();
                        }
                    },
                    loadMoreComments(){
                        if (this.isLoading || !this.hasMoreComments) return;
                        this.isLoading = true;
                        axios.post('/fetchComment',{
                            blog_id: "{{$blog->id}}",
                            page:this.page+1
                        },{
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                        })
                        .then((response)=>{
                            console.log(response.data.comments.data.length);
                            if (response.data.comments && response.data.comments.data.length > 0) {
                                this.comments.push(...response.data.comments.data);
                                this.page += 1;
                                this.isLoading=false; 
                                if(response.data.lastPage){
                                    this.hasMoreComments = false;
                                }
                                console.log(this.comments);
                                console.log(response.data.lastPage);
                            }else{
                                this.isLoading=false;
                                this.hasMoreComments = false;
                            }
                        })
                    },
                    follow(){
                        axios.post('/follow',{
                            author_id: "{{$blog->user->id}}"
                        },{
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                        })
                        .then((response)=>{
                            console.log(response.data.msg);
                            this.followed= response.data.followed;
                        })
                    },
                    heart(){
                        axios.post('/heartBlog',{
                            blog_id: "{{$blog->id}}"
                        },{
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                        })
                        .then((response)=>{
                            // document.getElementById("users-heart-count").innerHTML=response.data.heartCount;
                            this.heartCount = response.data.heartCount;
                            this.usersWhoHearts=response.data.usersWhoHearts;
                        })
                    },
                    comment(){
                        if(this.newComment.trim() === '') return;
                        axios.post('/comment',{
                            user_id: "{{Auth::user()->id}}",
                            blog_id: "{{$blog->id}}",
                            content: this.newComment
                        },{
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                        })
                        .then((response)=>{
                            this.comments.unshift(response.data.comment);
                            this.newComment = '';
                            this.commentCount += 1;
                        })
                    }
                }))
                Alpine.data('processComment', (idComment, heartedComment, heartCount)=> ({
                    showReplies:false,
                    showRepliesTemporary: true,
                    heartedComment: heartedComment,
                    heartCommentCount:heartCount,
                    replyComment: false,
                    newComment: '',
                    repliesList: [],
                    page:1,
                    hasMoreRepies: true,
                    heartComment(comment_id){
                        axios.post('/heartComment',{
                            comment_id: comment_id
                        },{
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                        })
                        .then((response)=>{
                            this.heartCommentCount=response.data.usersWhoHearts.length;
                            console.log(response.data.usersWhoHearts);
                        })
                    },
                    commentReply(comment_id){
                        if(this.newComment.trim() === '') return;
                        axios.post('/reply',{
                            user_id: "{{Auth::user()->id}}",
                            blog_id: "{{$blog->id}}",
                            comment_id: comment_id,
                            content: this.newComment
                        },{
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                        })
                        .then((response)=>{
                            this.repliesList.push(response.data.reply);
                            console.log(this.repliesList);
                            this.newComment = '';
                            this.commentCount += 1;
                        })
                    },
                    fetchReplies(comment_id){
                        axios.post('/fetchReplies',{
                            comment_id: comment_id,
                            page: this.page
                        },{
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                        })
                        .then((response)=>{
                            if(response.data.replies && response.data.replies.data.length >0){
                                if(this.showRepliesTemporary){
                                    this.repliesList = response.data.replies.data;
                                }else{
                                    this.repliesList.push(...response.data.replies.data);
                                }
                                
                                if(!this.showReplies){
                                    this.showRepliesTemporary=!this.showRepliesTemporary;
                                    this.showReplies=!this.showReplies;
                                }
                                this.page+=1;
                                if(response.data.lastPage){
                                    this.hasMoreComments = false;
                                }
                            }
                            console.log(this.repliesList);
                            console.log(response.data.replies.data);
                        })
                    },
                    renderReplies(obj){
                        let html=`
                                <div class="w-full" x-show="showRepliesTemporary">
                                        <template x-for="reply in repliesList" :key="reply.id">
                                            <div x-data="processComment(reply.id, reply.hearted_by_current_user, reply.hearted_count)"
                                                class="flex flex-col w-full justify-start items-start py-2">
                                                <div class="flex flex-col">
                                                    <div class="flex items-start w-full">
                                                        <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', reply.user.email.split('@')[0])" class="block">
                                                            <img :src="'{{ asset('storage/') }}' + '/' + reply.user.avatar"
                                                            class="w-10 h-10 rounded-full mr-3" />
                                                        </a>
                                                        <div class="p-2 bg-gray-200 rounded-md">
                                                            <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', reply.user.email.split('@')[0])" class="block">
                                                                <p x-text="reply.user.name" class="font-bold hover:underline"></p>
                                                            </a>
                                                            <p x-text="reply.content" class="text-gray-600"></p>
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-2 justify-start items-center w-full pl-12 pt-1">
                                                        <button class="hover:cursor-pointer flex items-center h-full"
                                                            @click="heartComment(reply.id);heartedComment=!heartedComment">
                                                            <template x-if="heartedComment">
                                                                <x-heroicon-s-heart id="sHeart"
                                                                    class="text-sky-500 w-5 h-5 " />
                                                            </template>
                                                            <template x-if="!heartedComment">
                                                                <x-heroicon-s-heart id="oHeart"
                                                                    class="text-gray-400 w-5 h-5 " />
                                                            </template>
                                                        </button>
                                                        <p class="hover:underline hover:cursor-pointer text-gray-400"
                                                            @click="replyComment=!replyComment">
                                                            Trả lời
                                                        </p>
                                                        <p class="text-gray-400 flex justify-center items-center border rounded-md px-1">
                                                            <span x-text="heartCommentCount"></span>
                                                            <x-heroicon-s-heart id="sHeart" class=" w-3 h-3 " />
                                                        </p>
                                                        <p class="text-gray-400" x-text="reply.formatted_time">
                                                        </p>
                                                    </div>
                                                </div>
                                                <div x-cloak x-show="replyComment" class="flex w-full box-content">
                                                    <form
                                                        x-data="{ newComment: '', textareaHeight: 40, maxHeight: 150, minHeight: 40 }"
                                                        x-init="textareaHeight = minHeight"
                                                        @submit="e=>{e.preventDefault(); commentReply(reply.id); replyComment=!replyComment}"
                                                        class="relative box-border bottom-0 w-full flex items-center flex-grow px-3 ml-12 border-l-2 border-gray-400 pb-2 z-50 bg-white">
                                                        <textarea x-ref="textarea" x-model='newComment'
                                                            class="flex-grow py-2 resize-none border-gray-300 focus:border-sky-500 focus:ring-sky-400 rounded-md shadow-sm overflow-hidden"
                                                            :placeholder="'Trả lời bình luận '+ reply.user.name"
                                                            :style="'height:' + textareaHeight + 'px; max-height:' + maxHeight + 'px; '"
                                                            @input="textareaHeight = $refs.textarea.scrollHeight > maxHeight ? maxHeight : $refs.textarea.scrollHeight;
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
                                                            ">
                                                        </textarea>
                                                        <button type='submit' x-ref='submitBtn'
                                                            @click="textareaHeight=minHeight;$refs.textarea.value = '';"
                                                            class="flex border-none justify-center items-center p-2 rounded-md hover:bg-gray-200 hover:cursor-pointer">
                                                            <x-carbon-send-filled class="w-8 h-8 text-sky-500  " />
                                                        </button>
                                                    </form>
                                                </div>
                                                <div x-html="renderReplies(reply)"></div>
                                            </div>
                                        </template>
                                    </div>
                                <div class="w-full pl-12" x-show="!showReplies">
                                        <template x-if="${obj.replies_count} > 0">
                                            <div class=" text-gray-400 ">
                                                <p @click="fetchReplies(${obj.id})" class="hover:underline hover:cursor-pointer">
                                                    Xem <span x-text="${obj.replies_count}"></span> câu trả lời</p>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="w-full" x-show="showReplies">
                                        <template x-for="reply in repliesList" :key="reply.id">
                                            <div x-data="processComment(reply.id, reply.hearted_by_current_user, reply.hearted_count)"
                                                class="flex flex-col w-full justify-start items-start py-2">
                                                <div class="flex flex-col">
                                                    <div class="flex items-start w-full">
                                                        <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', reply.user.email.split('@')[0])" class="block">
                                                            <img :src="'{{ asset('storage/') }}' + '/' + reply.user.avatar"
                                                            class="w-10 h-10 rounded-full mr-3" />
                                                        </a>
                                                        <div class="p-2 bg-gray-200 rounded-md">
                                                            <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', reply.user.email.split('@')[0])" class="block">
                                                                <p x-text="reply.user.name" class="font-bold hover:underline"></p>
                                                            </a>
                                                            <p x-text="reply.content" class="text-gray-600"></p>
                                                        </div>
                                                    </div>
                                                    <div class="flex gap-2 justify-start items-start w-full pl-12 pt-1" >
                                                        <button class="hover:cursor-pointer flex items-center h-full" @click="heartComment(reply.id);heartedComment=!heartedComment">
                                                            <template x-if="heartedComment">
                                                                <x-heroicon-s-heart id="sHeart" class="text-sky-500 w-5 h-5 " />
                                                                </template>
                                                                <template x-if="!heartedComment">
                                                                    <x-heroicon-s-heart id="oHeart" class="text-gray-400 w-5 h-5 " />
                                                                    </template>
                                                                    </button>
                                                                    <p class="hover:underline hover:cursor-pointer text-gray-400"
                                                                    @click="replyComment=!replyComment">
                                                                    Trả lời
                                                                    </p>
                                                                    <p
                                                                    class="text-gray-400 flex justify-center items-center border rounded-md px-1">
                                                                    <span x-text="heartCommentCount"></span>
                                                                    <x-heroicon-s-heart id="sHeart" class=" w-3 h-3 " />
                                                                    </p>
                                                                    <p class="text-gray-400" x-text="reply.formatted_time">
                                                                    </p>
                                                                    </div>
                                                                    </div>
                                                <div x-cloak x-show="replyComment" class="flex w-full box-content">
                                                    <form
                                                        x-data="{ newComment: '', textareaHeight: 40, maxHeight: 150, minHeight: 40 }"
                                                        x-init="textareaHeight = minHeight"
                                                        @submit="e=>{e.preventDefault(); commentReply(reply.id); replyComment=!replyComment;}"
                                                        class="relative box-border bottom-0 w-full flex items-center flex-grow px-3 ml-12 border-l-2 border-gray-400 pb-2 z-50 bg-white">
                                                        <textarea x-ref="textarea" x-model='newComment'
                                                            class="flex-grow py-2 resize-none border-gray-300 focus:border-sky-500 focus:ring-sky-400 rounded-md shadow-sm overflow-hidden"
                                                            :placeholder="'Trả lời bình luận '+ reply.user.name"
                                                            :style="'height:' + textareaHeight + 'px; max-height:' + maxHeight + 'px; '"
                                                            @input="textareaHeight = $refs.textarea.scrollHeight > maxHeight ? maxHeight : $refs.textarea.scrollHeight;
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
                                                            ">
                                                        </textarea>
                                                        <button type='submit' x-ref='submitBtn'
                                                            @click="textareaHeight=minHeight;$refs.textarea.value = '';"
                                                            class="flex border-none justify-center items-center p-2 rounded-md hover:bg-gray-200 hover:cursor-pointer">
                                                            <x-carbon-send-filled class="w-8 h-8 text-sky-500  " />
                                                        </button>
                                                    </form>
                                                </div>
                                                <div x-html="renderReplies(reply)"></div>
                                            </div>
                                        </template>
                                    </div>`;
                        return html;
                    }
                }))
            })
        </script>
    </x-slot>
</x-app-layout>