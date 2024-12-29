<x-app-layout>
    <x-slot name="slot">
        <div class="mx-5 sm:mx-14 md:mx-20 lg:mx-36 mt-24 flex flex-col">
            {{-- main --}}
            <main class="flex flex-col gap-4 w-full md:w-7/12 md:pr-14">
                <div class="flex justify-center items-center">
                    <h1 class="font-bold text-3xl">Kết quả cho "{{$query}}"</h1>
                </div>
                <ul class="flex gap-4 border-b border-gray-300 ">
                    <li class="block py-3 ">
                        <a href="{{route('search-page.blog',['query' => "$query"])}}" wire:navigate
                        class="block box-content text-gray-500 text-base hover:text-black">
                            Blog
                        </a>
                    </li>
                    <li class="block py-3 border-b border-black">
                        <a href="{{route('search-page.user',['query' => "$query"])}}" wire:navigate
                        class="block box-content text-base text black">
                            Người dùng
                        </a>
                    </li>
                </ul>
                {{-- blog-contain --}}
                <div class="flex flex-col">
                    @if($userResults->isNotEmpty())
                                @foreach($userResults as $user)
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
                                    @if($user->id !== Auth::user()->id)
                                    <div class="flex justify-center items-center">
                                        <button x-cloak x-show="!followed" @click="follow()"
                                            class=" flex justify-center text-sm items-center bg-mainColor1 text-white p-2 rounded-3xl">Theo
                                            dõi</button>
                                        <button x-claok x-show="followed" @click="follow()"
                                            class=" flex justify-center text-sm items-center border border-mainColor1 text-mainColor1 p-2 rounded-3xl">Đang
                                            theo dõi</button>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            @else 
                            <div><p>Không có người dùng nào phù hợp với kết quả tìm kiếm</p></div>
                            @endif
            </main>
            
        </div>
    </div>
    </x-slot>
</x-app-layout>