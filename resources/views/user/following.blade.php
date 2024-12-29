@php
use Illuminate\Support\Facades\Crypt;
@endphp
<x-app-layout>
    <x-slot name="slot">
        <div x-data="">
            <div class="mx-1 sm:mx-5 lg:mx-20 xl:mx-36 mt-24 flex flex-col md:flex-row">
                {{-- main --}}
                <main class="flex flex-col gap-4 w-full md:w-7/12 md:pr-14 order-2 md:order-1">
                    <ul class="flex items-center gap-2">
                        <li class="block py-3">
                            <a href="{{route('user.info',['infoUser'=> Str::before($user->email, '@') ])}}" class="block box-content text-base text-gray-500 hover:text-black">
                                {{$user->name}}
                            </a>
                        </li>
                        <x-bi-chevron-right class="w-4 h-4"/>
                        <li class="block py-3"><a href="{{route('user.info.follower',['infoUser'=> Str::before($user->email, '@') ])}}"
                                class="block box-content text-black text-base hover:text-black">Đang theo dõi</a>
                        </li>
                    </ul>
                    <div class="flex items-center">
                        <h1 class="text-4xl font-bold">{{$user->following->count()}} đang theo dõi</h1>
                    </div>
                    {{-- followers-contain --}}
                    <div class="flex flex-col">
                        <div class="">
                            @if($user->following->isNotEmpty())
                            @foreach($user->following as $following)
                                {{-- user--}}
                                <div x-data="followData({{ Auth::user()->following->contains($following->id) ? 'true' : 'false' }}, {{ $following->id }})" class="flex justify-between w-full py-3">
                                    <div class="flex justify-center items-center gap-2">
                                        <div class="flex justify-center items-center relative">
                                            <a href="{{route('user.info',['infoUser'=> Str::before($following->email, '@') ])}}" class="block">
                                                <img src="{{asset('storage/'.$following->avatar)}}"
                                                    class="w-10 h-10 hover:opacity-60 rounded-full" alt="">
                                            </a>
                                        </div>
                                        <div class="flex">
                                            <a href="{{route('user.info',['infoUser'=> Str::before($following->email, '@') ])}}">
                                                <h1 class="hover:underline">{{$following->name}}</h1>
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
                                <div class="flex justify-center items-center">
                                    <p class="text-bold text-lg">Chưa theo dõi người nào</p>
                                </div>
                                @endif
                        </div>
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
                                    <a href="{{route('user.info.follower',['infoUser'=> Str::before($user->email, '@')])}}" class="text-gray-500 text-base md:text-lg hover:text-black hover:cursor-pointer truncate ...">
                                        {{$user->followers->count()}} người theo dõi</a>
                                </div>
                                {{-- quantity following --}}
                                <div class="flex items-center">
                                    <a href="{{route('user.info.following',['infoUser'=> Str::before($user->email, '@')])}}" class="text-gray-500 text-base md:text-lg hover:text-black hover:cursor-pointer truncate ...">
                                        {{$user->following->count()}} đang theo dõi</a>
                                </div>
                            </div>
                        </div>
                        {{-- contact with user --}}
                        <div x-data="followData({{ Auth::user()->following->contains($user->id) ? 'true' : 'false' }}, {{ $user->id }})" class="flex items-center gap-2">
                            @if($user->id!=Auth::user()->id)
                            <button x-show="!followed" @click="follow()"
                                class="flex flex-grow sm:flex-grow-0 justify-center items-center text-sm md:text-base bg-mainColor1 rounded-3xl p-2 text-nowrap text-white">
                                Theo dõi
                            </button>
                            <button x-show="followed" @click="follow()"
                                class="flex flex-grow sm:flex-grow-0 justify-center items-center border text-sm md:text-base border-mainColor1 rounded-3xl p-2 text-mainColor1">
                                Đã theo dõi
                            </button>
                            <a href="" @click="e=>{e.preventDefault();document.getElementById('submit').click()}"
                                class="flex flex-grow sm:flex-grow-0 justify-center items-center text-sm md:text-base bg-mainColor1 text-white rounded-3xl p-2 text-nowrap">
                                <x-carbon-chat class="w-3 h-3 md:w-6 md:h-6 pr-1" />Nhắn tin
                            </a>
                            <form id="chat-form" action="{{route('chat')}}" method="post">
                                @csrf
                                <input type="hidden" name="userTargetID" value={{$user->id}}>
                                <button type="submit" id="submit" class="hidden">Xác nhận</button>
                            </form>
                            @else
                            <a href="{{route('profile')}}"
                                class="flex flex-grow sm:flex-grow-0 justify-center items-center text-sm md:text-base text-mainColor1 rounded-3xl p-2 text-nowrap">
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
    </x-slot>
</x-app-layout>