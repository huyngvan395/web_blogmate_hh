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
                        <li class="block py-3 border-b border-black"
                        :class="{'border-b border-black': currentUrl === '{{route('blog')}}'}">
                            <a href="{{route('blog')}}" wire:navigate
                            class="block box-content text-base hover:text-black"
                            :class="{'text-black': currentUrl === '{{route('blog')}}', 'text-gray-500': currentUrl !== '{{route('blog')}}'}">
                                Dành cho bạn
                            </a>
                        </li>
                        <li class="block py-3" 
                        :class="{'border-b border-black': currentUrl === '{{route('blog')}}/following'}">
                            <a href="{{route('blog.following')}}" wire:navigate
                            class="block box-content text-base hover:text-black"
                            :class="{'text-black': currentUrl === '{{route('blog')}}/following', 'text-gray-500': currentUrl !== '{{route('blog')}}/following'}">
                                Đang theo dõi
                            </a>
                        </li>
                    </ul>
                    {{-- blog-contain --}}
                    <div class="flex flex-col overflow-y-scroll h-99">
                        @if($blogs->isNotEmpty())
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
                                        <div class="flex p-2">
                                            <div class="md:w-2/3 w-7/12">
                                                <h1 class="text-xl md:text-2xl leading-10 font-bold line-clamp-3 ">
                                                    {{$blog->title}}</h1>
                                                    <div class="flex">
                                                        <div class="pt-2 flex w-full">
                                                            {{-- hearts --}}
                                                            <div class="flex justify-center items-center">
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
                                            {{-- image-blog --}}
                                            <div class="flex items-start justify-start pl-10 md:w-1/3 w-5/12">
                                                @if(!empty($blog->image_blog))
                                                <div class="flex justify-end items-start w-full"><img
                                                    src="{{$blog->image_blog}}"
                                                    class="w-32 h-16 md:h-28 md:w-40 rounded-md" alt="">
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        @else
                        <div class="flex justify-center items-center">
                            <p class="font-bold text-xl">Không có blog nào</p>
                        </div>
                        @endif
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
                                            <a href="{{route('user.info',['infoUser' => Str::before($user->email, '@')])}}" class="block">
                                                <img src="{{asset('storage/'.$user->avatar)}}"
                                                    class="w-10 h-10 hover:opacity-60 rounded-full" alt="">
                                            </a>
                                        </div>
                                        <div class="flex">
                                            <a href="{{route('user.info',['infoUser' => Str::before($user->email, '@')])}}">
                                                <h1 class="hover:underline">{{$user->name}}</h1>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="flex justify-center items-center">
                                        <button x-cloak x-show="!followed" @click="follow()"
                                            class=" flex justify-center text-sm items-center bg-mainColor1 text-white p-2 rounded-3xl">Theo
                                            dõi</button>
                                        <button x-claok x-show="followed" @click="follow()"
                                            class=" flex justify-center text-sm items-center border border-mainColor1 text-mainColor1 p-2 rounded-3xl">Đang
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