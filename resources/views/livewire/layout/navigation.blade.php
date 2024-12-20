<div x-data="{ open: false, openUser: false, currentUrl: window.location.href, 
            updateCurrentUrl() {
                this.currentUrl = window.location.href;
            } 
    }"
    class="fixed z-40
     top-0 left-0 right-0 w-full flex flex-wrap items-center border-b border-gray-300 justify-between mx-auto p-4 bg-gray-100 shadow-md">
    {{-- logo --}}
    <a href={{route("home")}} class=" flex items-center space-x-3" wire:navigate>
        <img src="{{asset('images/logo/logo_blogmate.png')}}" class="h-12 sm:h-18" alt="Logo" />
        {{-- <span class="self-center text-xl sm:text-2xl font-semibold whitespace-nowrap text-sky-500">Green Planet</span> --}}
    </a>
    {{-- auth --}}
    <div class="flex items-center gap-1 md:order-2">
        @auth
        <a title="Tạo blog" href="{{route('blog.create')}}" wire:navigate
        :class="{'text-sky-500 bg-sky-200': currentUrl === '{{route('blog.create')}}'}"
        @click="updateCurrentUrl()" class="flex justify-center item-center text-gray-500 rounded-full bg-gray-300 p-2 hover:text-sky-500 hover:bg-sky-200">
            <x-bi-pencil-square 
            :class="{'text-sky-500': currentUrl === '{{route('blog.create')}}'}"
            class="fill-current h-6 w-6 "/>
        </a>
        <a title="Nhắn tin" href="" @click="e=>{e.preventDefault(); document.getElementById('chat-form').submit(); updateCurrentUrl()}" 
            class="flex justify-center item-center text-gray-500 rounded-full bg-gray-300 p-2 hover:text-sky-500 hover:bg-sky-200" 
            :class="{'text-sky-500 bg-sky-200': currentUrl === '{{route('chat')}}'}" wire:navigate>
            <x-heroicon-s-chat-bubble-left-right
             class="fill-current h-6 w-6" />
        </a>
        <form id="chat-form" action="{{route('chat')}}" method="POST" class="hidden">
            @csrf
        </form>
        <a title="Thông báo" href="" class="flex justify-center item-center text-gray-500 rounded-full bg-gray-300 p-2 hover:text-sky-500 hover:bg-sky-200">
            <x-heroicon-s-bell class="fill-current h-6 w-6 "/>
        </a>
        <button class="mr-2 hover:cursor-pointer rounded-full focus:ring-gray-300 focus:ring-4" @click="openUser = !openUser">
            <img src="{{asset('storage/'.auth()->user()->avatar)}}" alt="Avatar" class="w-8 h-8 rounded-full">
        </button>
        @else
        <a href="{{ route("login")}}"
            class="text-white bg-sky-500 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-2" wire:navigate>Đăng nhập</a>
        @endauth
        <button @click="open= ! open" class="border border-gray-500 rounded-md text-gray-500 block sm:hidden">
            <x-heroicon-c-bars-3 x-show="!open" class="block size-8"/>
            <x-heroicon-c-x-mark x-show="open" class="block size-8"/>
        </button>
    </div>
    {{-- main-nav --}}
    <div class="item-centers justify-center w-full flex md:w-auto md:order-1">
        <ul :class="{'flex':open, 'hidden': !open}"
            class="animate-navigationShow hidden md:flex w-full flex-col font-medium border rounded-lg mt-2 border-gray-400 p-4 hover:text-white md:border-0 md:hover:bg-transparent md:hover:text-sky-500 md:flex-row md:mt-0 md:p-0 md:space-x-8 ">
            <li>
                <a href={{ route("home")}}
                    :class="{'border-b border-sky-500 text-sky-500': currentUrl === '{{ route('home') }}'}"
                    class="block px-3 py-2 text-lg md:p-0 hover:text-sky-500 hover:bg-gray-200 text-gray-500 md:hover:bg-transparent"
                    wire:navigate  @click="updateCurrentUrl()">Trang chủ</a>
            </li>
            <li>
                <a href={{ route("blog")}}
                    :class="{'border-b border-sky-500 text-sky-500': currentUrl === '{{ route('blog') }}'}"
                    class="block px-3 py-2 text-lg md:p-0 hover:text-sky-500 hover:bg-gray-200 text-gray-500 md:hover:bg-transparent"
                    wire:navigate  @click="updateCurrentUrl()">Blog</a>
            </li>
            <li>
                <a href={{ route("about_us")}}
                    :class="{'border-b border-sky-500 text-sky-500': currentUrl === '{{ route('about_us') }}'}"
                    class="block px-3 py-2 text-lg md:p-0 hover:text-sky-500 hover:bg-gray-200 text-gray-500 md:hover:bg-transparent"
                    wire:navigate  @click="updateCurrentUrl()">Về chúng tôi</a>
            </li>
            {{-- <li>
                <a href={{ route("project")}}
                    class="block px-3 py-2 text-lg md:p-0 hover:text-sky-500 hover:bg-gray-200 text-gray-500 md:hover:bg-transparent"
                    wire:navigate>Dự án</a>
            </li> --}}
            <li>
                <a href={{ route("contact")}}
                    :class="{'border-b border-sky-500 text-sky-500': currentUrl === '{{ route('contact') }}'}"
                    class="block px-3 py-2 text-lg md:p-0 hover:text-sky-500 hover:bg-gray-200 text-gray-500 md:hover:bg-transparent"
                    wire:navigate  @click="updateCurrentUrl()">Liên hệ</a>
            </li>
        </ul>
    </div>
    @auth
    <div x-cloak x-show="openUser" class="absolute flex flex-col right-0 top-14 shadow-lg rounded-md z-50 bg-gray-200">
        <a href={{route('user.info',['infoUser'=> Str::before(Auth::user()->email, '@') ])}} class="flex justify-start items-center p-2 text-gray-500 rounded-md hover:bg-gray-300" wire:navigate><x-carbon-user-filled class="w-5 h-5"/>Trang cá nhân</a>
        <a href={{route('statistical')}}  class="flex justify-start items-center p-2 text-gray-500 rounded-md hover:bg-gray-300" wire:navigate><x-bi-clipboard-data class="w-5 h-5"/>Thống kê số liệu</a>
        <a href="#" @click="e=>{e.preventDefault();document.getElementById('logout-form').submit()}" class="flex justify-start items-center p-2 rounded-md hover:bg-gray-300 text-gray-500"><x-carbon-logout class="h-5 w-5"/> Đăng xuất</a>
    </div>
    <form id="logout-form" action="{{route('logout')}}" method="POST" class="hidden">
        @csrf
    </form>
    @endauth
</div>
