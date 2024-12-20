@php
use Illuminate\Support\Facades\Crypt;
@endphp
<x-app-layout>
    <x-slot name="slot">
        <div x-data="dataInfoUser">
            <div class="mx-1 sm:mx-5 lg:mx-20 xl:mx-36 mt-20 flex flex-col md:flex-row">
                {{-- main --}}
                <main class="flex flex-col gap-4 w-full md:w-7/12 md:pr-14 order-2 md:order-1">
                    <div class="flex items-center">
                        <div class="hidden md:flex items-center">
                            <h1 class="text-3xl font-bold">{{$user->name}}</h1>
                        </div>
                        <div class="md:flex justify-end items-center flex-grow hidden">
                            <button class="flex items-center justify-center p-2 rounded-md">
                                <x-bi-three-dots class="text-gray-500 w-6 h-6 hover:text-gray-800" />
                            </button>
                        </div>
                    </div>
                    <ul class="flex gap-4 border-b border-gray-300 ">
                        <li class="block py-3 border-b border-black"><button id="for-you"
                                class="block box-content text-base hover:text-black">Trang chính</button></li>
                        <li class="block py-3"><button id="following"
                                class="block box-content text-gray-500 text-base hover:text-black">Về tôi</button>
                        </li>
                    </ul>
                    {{-- blog-contain --}}
                    <div class="flex flex-col">
                        @if(! $user->blog->isEmpty())
                            @foreach($user->blog as $blog)
                            {{-- blog-item --}}
                            <div @click="directToBlogDetail($event)" data-id="{{Crypt::encryptString($blog->id)}}"
                                class="block box-border pt-5 hover:cursor-pointer relative"
                                x-data="{showMoreOptionAction: false}">
                                <div class="flex flex-col">
                                    {{-- user-info --}}
                                    <div class="flex gap-2 items-center">
                                        <div class="flex justify-center items-center py-3">
                                            <a class="block"
                                                href="{{route('user.info',['infoUser'=> Str::before($blog->user->email, '@') ])}}">
                                                <img src="{{asset('storage/'.$blog->user->avatar)}}"
                                                    class="w-6 h-6 hover:opacity-60 rounded-full" alt="Ảnh đại diện"
                                                    @click.prevent="window.location.href=''">
                                            </a>
                                        </div>
                                        <div class="flex">
                                            <a class="block"
                                                href="{{route('user.info',['infoUser'=> Str::before($blog->user->email, '@') ])}}">
                                                <h1 class="hover:underline text-sm">{{$blog->user->name}}</h1>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- blog-info --}}
                                    <div class="flex ">
                                        <div class="flex flex-col w-full border-b border-gray-300">
                                            <div class="flex">
                                                <div class="md:w-2/3 w-7/12">
                                                    <h1
                                                        class="text-xl md:text-3xl leading-10 font-bold line-clamp-2 hover:underline">
                                                        {{$blog->title}}</h1>
                                                </div>
                                                {{-- image-blog --}}
                                                <div class="flex items-end justify-start pl-10 md:w-1/3 w-5/12">
                                                    <div class="flex justify-end items-start w-full"><img
                                                            src="{{$blog->image_blog}}"
                                                            class="w-32 h-16 md:h-28 md:w-40 rounded-md" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex p-4">
                                                <div class="pt-2 flex w-full">
                                                    {{-- hearts --}}
                                                    <div class="flex justify-center items-center pl-2">
                                                        <button class="flex text-gray-500">
                                                            <x-heroicon-s-heart class="fill-current w-5 h-5 " />
                                                            {{$blog->usersWhoHearts->count()}}
                                                        </button>
                                                    </div>
                                                    {{-- comments --}}
                                                    <div class="flex px-4">
                                                        <button name="comment" id="comment"
                                                            class="flex text-gray-500 justify-center items-center ">
                                                            <x-gmdi-mode-comment-s class="fill-current w-5 h-5" />
                                                            {{$blog->comment->count()}}
                                                        </button>
                                                    </div>
                                                    {{-- more-option --}}
                                                    @if($user->id==Auth::user()->id)
                                                        <div class="flex justify-end items-center flex-grow pr-3">
                                                            <button
                                                                @click="e => {e.stopPropagation(); toggleMenu()}"
                                                                class="hover:bg-gray-200 p-2 rounded-md">
                                                                <x-bi-three-dots
                                                                    class="text-gray-500 w-5 h-5  hover:text-gray-800" />
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
    
                                        </div>
    
                                    </div>
                                </div>
                                {{-- more-option-action --}}
                                <div x-show="showMoreOptionAction" x-ref="menuMoreOption" class="absolute right-0 -bottom-5 rounded-md bg-white shadow-lg z-50">
                                    <button @click="e=>{e.stopPropagation()}"
                                        class="text-red-600 hover:bg-gray-200 p-2 rounded-md">
                                        Delete
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @else 
                            <div>
                                @if($user->id != Auth::user()->id)
                                <h1>Người dùng này chưa đăng blog nào</h1>
                                @else
                                <h1>Bạn chưa đăng blog nào</h1>
                                @endif
                            </div>
                        @endif
                    </div>
                </main>
                {{-- user-info--}}
                <div class="w-full md:w-5/12 md:border-l border-gray-300 order-1 md:order-2">
                    <div class="flex flex-col sm:flex-row md:flex-col gap-3 md:px-20">
                        <div class="flex flex-row md:flex-col gap-3">
                            {{-- image-user --}}
                            <div class="flex justify-start items-center">
                                <img src="{{asset('storage/'.$user->avatar)}}"
                                    class="w-6 h-6 sm:w-8 sm:h-8 md:w-20 md:h-20 rounded-full" alt="">
                            </div>
                            <div class="flex flex-col justify-center flex-grow md:flex-grow-0">
                                {{-- name --}}
                                <div class="flex items-center">
                                    <h1 class="font-bold text-lg">{{$user->name}}</h1>
                                </div>
                                {{-- quantity followers --}}
                                <div class="flex items-center">
                                    <a href=""
                                        class="text-gray-500 text-base md:text-lg hover:text-black hover:cursor-pointer truncate ...">500
                                        người theo
                                        dõi</a>
                                </div>
                            </div>
                        </div>
                        {{-- contact with user --}}
                        <div class="flex items-center gap-2">
                            @if($user->id!=Auth::user()->id)
                            <button x-show="!followed" @click="follow()"
                                class="flex flex-grow sm:flex-grow-0 justify-center items-center text-sm md:text-base bg-sky-500 rounded-3xl p-2 text-nowrap text-white">
                                Theo dõi
                            </button>
                            <button x-show="followed" @click="follow()"
                                class="flex flex-grow sm:flex-grow-0 justify-center items-center border text-sm md:text-base border-sky-500 rounded-3xl p-2 text-sky-500">
                                Đã theo dõi
                            </button>
                            <a href="" @click="e=>{e.preventDefault();document.getElementById('submit').click()}"
                                class="flex flex-grow sm:flex-grow-0 justify-center items-center text-sm md:text-base bg-sky-500 text-white rounded-3xl p-2 text-nowrap">
                                <x-carbon-chat class="w-3 h-3 md:w-6 md:h-6 pr-1" />Nhắn tin
                            </a>
                            <form id="chat-form" action="{{route('chat')}}" method="post">
                                @csrf
                                <input type="hidden" name="userTargetID" value={{$user->id}}>
                                <button type="submit" id="submit" class="hidden">Xác nhận</button>
                            </form>
                            @else
                            <a href="{{route('profile')}}"
                                class="flex flex-grow sm:flex-grow-0 justify-center items-center text-sm md:text-base text-sky-500 rounded-3xl p-2 text-nowrap">
                                Quản lí tài khoản
                            </a>
                            @endif
                            <button class="md:hidden flex-grow-0 flex items-center justify-center">
                                <x-bi-three-dots class="text-gray-500 w-6 h-6 hover:text-gray-800" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('dataInfoUser', () => ({
                    showMoreOptionAction: false,
                    followed: {{ $user->followers->contains(Auth::user()->id) ? 'true' : 'false'}} ,
                    menuMoreOptionRef: null,
                    init(){
                        console.log(this.followed);
                    },
                    toggleMenu() {
                        this.showMoreOptionAction = !this.showMoreOptionAction;

                        if (this.showMoreOptionAction) {
                            this.$nextTick(() => {
                                this.menuMoreOptionRef = this.$refs.menuMoreOption;
                                console.log(this.menuMoreOptionRef);
                                document.addEventListener('click', this.handleClickOutside.bind(this));
                            });
                        } else {
                            document.removeEventListener('click', this.handleClickOutside);
                        }
                    },
                    follow(){
                        axios.post('/follow',{
                            author_id: "{{$user->id}}"
                        },{
                            headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
                        })
                        .then((response)=>{
                            console.log(response.data.msg);
                            this.followed= response.data.followed;
                        })
                    },
                    handleClickOutside(event) {
                        console.log(this.menuMoreOptionRef);
                        event.preventDefault();
                        event.stopPropagation();
                        console.log(event.target);
                        if (this.menuMoreOptionRef && !this.menuMoreOptionRef.contains(event.target)) {
                            console.log("Thành công");
                            this.showMoreOptionAction = false;
                            document.removeEventListener('click', this.handleClickOutside);
                        }
                    },
                    directToBlogDetail(event){
                        if(this.showMoreOptionAction){
                            return;
                        }else{
                            const hash_id= event.currentTarget.getAttribute('data-id'); 
                            window.location.href=`{{route('blog.blog-detail', ['id'=> '__ID__'])}}`.replace('__ID__', hash_id);
                        }
                    }
                }))
            })
            const userTargetID = document.querySelector('input[name="userTargetID"]').value;
            console.log('userTargetID:', userTargetID);
        </script>
    </x-slot>
</x-app-layout>