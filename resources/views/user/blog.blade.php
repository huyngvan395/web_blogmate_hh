@php
use Illuminate\Support\Facades\Crypt;
@endphp
<x-app-layout>
    <x-slot name="slot">
        <div x-data="dataBlog">
            <div class="mx-5 sm:mx-14 md:mx-20 lg:mx-36 mt-20 flex ">
                {{-- main --}}
                <main class="flex flex-col gap-4 w-full md:w-7/12 md:pr-14">
                    <ul class="flex gap-4 border-b border-gray-300 ">
                        <li class="block py-3 border-b border-black">
                            <button id="for-you" class="block box-content text-base hover:text-black">
                                Dành cho bạn
                            </button>
                        </li>
                        <li class="block py-3">
                            <button id="following" class="block box-content text-gray-500 text-base hover:text-black">
                                Đang theo dõi
                            </button>
                        </li>
                    </ul>
                    {{-- blog-contain --}}
                    <div class="flex flex-col">
                        @foreach($blogs as $blog)
                        @if($blog->user_id != auth()->user()->id)
                        {{-- blog-item --}}
                        <div data-id="{{Crypt::encryptString($blog->id)}}" onclick="directToBlogDetail(this)"
                            class="block box-border pt-5 hover:cursor-pointer relative">
                            <div class="flex flex-col">
                                {{-- user-info --}}
                                <div class="flex gap-2 items-center">
                                    <div class="flex justify-center items-center py-3">
                                        <a class="block"
                                            href="{{route('user.info',['infoUser'=> Str::before($blog->user->email, '@') ])}}">
                                            <img src="{{asset('storage/'.$blog->user->avatar)}}"
                                                class="w-6 h-6 hover:opacity-60 rounded-full" alt="Ảnh đại diện">
                                        </a m>
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
                                                @if(!empty($blog->image_blog))
                                                <div class="flex justify-end items-start w-full"><img
                                                    src="{{$blog->image_blog}}"
                                                    class="w-32 h-16 md:h-28 md:w-40 rounded-md" alt="">
                                                </div>
                                                @endif
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
                                                <div class="flex justify-end items-center flex-grow pr-3">
                                                    <button class="hover:bg-gray-200 p-2 rounded-md" @click="e => {e.stopPropagation(); console.log('Thành công'); showMoreOptionAction = !showMoreOptionAction }">
                                                        <x-bi-three-dots
                                                            class="text-gray-500 w-5 h-5 hover:text-gray-800" />
                                                    </button>
                                                </div>
                                                {{-- more-option-action --}}
                                                {{-- <div x-show="showMoreOptionAction"
                                                    class="absolute right-0 -bottom-5 rounded-md bg-white p-2 shadow-lg z-50">
                                                    <button @click="e=>{e.stopPropagation()}" class="text-red-600">
                                                        Delete
                                                    </button>
                                                </div> --}}
                                            </div>
                                        </div>
    
                                    </div>
    
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </main>
                {{-- People you may know --}}
                <div class="hidden md:block w-5/12 border-l border-gray-300">
                    <div class="px-5 lg:px-10 xl:px-20">
                        <h1 class="py-3 text-lg font-bold">Đề xuất theo dõi</h1>
                        <div class="flex flex-col">
                            @if($usersWithMostFollowers->isNotEmpty())
                                @foreach($usersWithMostFollowers as $user)
                                {{-- user--}}
                                <div x-data="followData({{ $user->is_followed ? 'true' : 'false' }}, {{ $user->id }})" class="flex justify-between w-full py-3">
                                    <div class="flex justify-center items-center gap-2">
                                        <div class="flex justify-center items-center relative">
                                            <a href="{{route('chat')}}" class="block">
                                                <img src="{{asset('storage/'.$user->avatar)}}"
                                                    class="w-10 h-10 hover:opacity-60 rounded-full" alt="">
                                            </a>
                                        </div>
                                        <div class="flex">
                                            <a href="#">
                                                <h1 class="hover:underline">{{$user->name}}</h1>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="flex justify-center items-center">
                                        <button x-cloak x-show="!followed" @click="follow()"
                                            class=" flex justify-center text-sm items-center bg-sky-500 text-white p-2 rounded-3xl">Theo
                                            dõi</button>
                                        <button x-claok x-show="followed" @click="follow()"
                                            class=" flex justify-center text-sm items-center border border-sky-500 text-sky-500 p-2 rounded-3xl">Đang
                                            theo dõi</button>
                                    </div>
                                </div>
                                @endforeach
                            @else 
                            <div><p>Không có đề xuất theo dõi nào</p></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function directToBlogDetail(element){
                const hash_id= element.getAttribute('data-id'); 
                window.location.href=`{{route('blog.blog-detail', ['id'=> '__ID__'])}}`.replace('__ID__', hash_id);
            }
        </script>
    </x-slot>
</x-app-layout>