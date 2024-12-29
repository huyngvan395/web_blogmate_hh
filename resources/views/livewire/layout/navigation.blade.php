<div x-data="dataNavigation"
    class="fixed z-40
     top-0 left-0 right-0 w-full flex flex-wrap items-center border-b-2 border-gray-300 justify-between mx-auto bg-gray-100 shadow-md">
    {{-- logo --}}
    <div class="flex relative">
        <a href={{route("home")}} class=" flex items-center px-2 relative" wire:navigate>
            <img src="{{asset('images/logo/BlogMate.webp')}}" class="h-12 sm:h-20" alt="Logo" />
        </a>
        <form action="{{route('search-page')}}" class="flex justify-center items-center">
            <label for="search" class="flex justify-center items-center h-10 rounded-tl-2xl rounded-bl-2xl bg-white pl-1">
                <x-gmdi-search class="w-8 h-8 text-gray-400 p-0" />
            </label>
            <input id="search" type="text" x-model="query" name="query" @input="search()" class="rounded-tr-2xl rounded-br-2xl h-10 border-0 focus:ring-0" placeholder="Tìm kiếm trên BlogMate">
        </form>
        <div x-cloak x-show="query.length > 0 && (searchBlogResults.length > 0 || searchUserResults.length > 0 )" class="absolute bg-white top-16 left-40 border shadow-lg mt-2 w-full p-4">
            <template x-if="searchUserResults.length > 0">
                <ul >
                    <h1 class="font-bold text-xl">Người dùng</h1>
                    <template x-for="user in searchUserResults" :key="user.id">
                        <li>
                            <a :href="'{{ route('user.info', ['infoUser' => 'temp']) }}'.replace('temp', user.email.split('@')[0])" class="flex justify-start gap-2 items-center p-2 hover:bg-gray-200">
                                <img :src="'{{asset('storage/')}}' + '/' + user.avatar" alt="" class="rounded-full w-8 h-8">
                                <p x-text="user.name" class="text-bold text-lg"></p>
                            </a>
                        </li>
                    </template>
                </ul>
            </template>
            <template x-if="searchBlogResults.length > 0">
                <ul>
                    <h1 class="font-bold text-xl">Blog</h1>
                    <template x-for="blog in searchBlogResults" :key="blog.id">
                        <li>
                            <a :href="'{{ route('blog.blog-detail', ['id' => 'temp']) }}'.replace('temp', blog.hash_id)" class="block p-2 hover:bg-gray-200" x-text="blog.title"></a>
                        </li>
                    </template>
                </ul>
            </template>
        </div>
    </div>
    
    {{-- auth --}}
    <div class="flex items-center gap-1 md:order-2">
        @auth
        <a title="Tạo blog" href="{{route('blog.create')}}" wire:navigate
        :class="{'text-mainColor1 bg-mainColor2_300': currentUrl === '{{route('blog.create')}}'}"
         class="flex justify-center item-center text-gray-500 rounded-full bg-gray-300 p-2 hover:text-mainColor1 hover:bg-mainColor2_300">
            <x-bi-pencil-square 
            :class="{'text-mainColor1': currentUrl === '{{route('blog.create')}}'}"
            class="fill-current h-6 w-6 "/>
        </a>
        <a title="Nhắn tin" href="" @click="e=>{e.preventDefault(); document.getElementById('chat-form').submit(); }" 
            class="flex justify-center item-center text-gray-500 rounded-full bg-gray-300 p-2 hover:text-mainColor1 hover:bg-mainColor2_300 relative" 
            :class="{'text-mainColor1 bg-mainColor2_300': currentUrl === '{{route('chat')}}'}" wire:navigate>
            <x-heroicon-s-chat-bubble-left-right class="fill-current h-6 w-6" />
            <template x-if="count_message > 0">
                <div class="absolute flex justify-center items-center top-0 -right-1 text-sm rounded-full bg-red-500 text-white p-1 w-4 h-4">1</div>
            </template>
        </a>
        <form id="chat-form" action="{{route('chat')}}" method="POST" class="hidden">
            @csrf
        </form>
        {{-- Thông báo --}}
        <a title="Thông báo" href="" @click="e=>{e.preventDefault(); showNotifications=!showNotifications;}"
           class="flex justify-center item-center text-gray-500 rounded-full bg-gray-300 p-2 hover:text-mainColor1 hover:bg-mainColor2_300 relative"
           :class="{'text-mainColor1 bg-mainColor2_300' : showNotifications}">
            <x-heroicon-s-bell class="fill-current h-6 w-6 "/>
            <template x-if="count_notification > 0">
                <div x-text="count_notification" class="absolute flex justify-center items-center top-0 -right-1 text-sm rounded-full bg-red-500 text-white p-1 w-4 h-4"></div>
            </template>
        </a>
        <button class="mr-2 hover:cursor-pointer rounded-full focus:ring-gray-300 focus:ring-4" @click="openUser = !openUser">
            <img src="{{asset('storage/'.auth()->user()->avatar)}}" alt="Avatar" class="w-8 h-8 rounded-full">
        </button>
        @else
        <a href="{{ route("login")}}"
            class="text-white bg-mainColor1 hover:bg-mainColor1_600 focus:ring-4 focus:outline-none focus:ring-mainColor1_300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-2" wire:navigate>Đăng nhập</a>
        @endauth
        <button @click="open= ! open" class="border border-gray-500 rounded-md text-gray-500 block sm:hidden">
            <x-heroicon-c-bars-3 x-show="!open" class="block size-8"/>
            <x-heroicon-c-x-mark x-show="open" class="block size-8"/>
        </button>
    </div>
    {{-- main-nav --}}
    <div class="item-centers justify-center w-full flex md:w-auto md:order-1">
        <ul :class="{'flex animate-navigationShow':open, 'hidden': !open}"
            class="hidden md:flex w-full flex-col font-medium border rounded-lg mt-2 border-gray-400 p-4 hover:text-white md:border-0 md:hover:bg-transparent md:hover:text-mainColor1 md:flex-row md:mt-0 md:p-0 md:space-x-8 ">
            <li>
                <a href={{ route("home")}} wire:navigate 
                    :class="{'border-b-4 border-mainColor2 text-mainColor1': currentUrl === '{{ route('home') }}'}"
                    class="block px-3 py-2 text-xl md:p-0 hover:text-mainColor1 hover:bg-gray-200 text-gray-500 md:hover:bg-transparent"
                      >Trang chủ</a>
            </li>
            <li>
                <a href={{ route("blog")}} wire:navigate 
                :class="{
                    'border-b-4 border-mainColor2 text-mainColor1': currentUrl === '{{ route('blog.following') }}' || currentUrl === '{{ route('blog') }}'}"
                    class="block px-3 py-2 text-xl md:p-0 hover:text-mainColor1 hover:bg-gray-200 text-gray-500 md:hover:bg-transparent"
                     >Blog</a>
            </li>
            <li>
                <a href={{ route("about_us")}} wire:navigate 
                    :class="{'border-b-4 border-mainColor2 text-mainColor1': currentUrl === '{{ route('about_us') }}'}"
                    class="block px-3 py-2 text-xl md:p-0 hover:text-mainColor1 hover:bg-gray-200 text-gray-500 md:hover:bg-transparent"
                     ">Về chúng tôi</a>
            </li>
            {{-- <li>
                <a href={{ route("project")}}
                    class="block px-3 py-2 text-lg md:p-0 hover:text-mainColor1 hover:bg-gray-200 text-gray-500 md:hover:bg-transparent"
                    wire:navigate>Dự án</a>
            </li> --}}
            <li>
                <a href={{ route("contact")}} wire:navigate 
                    :class="{'border-b-4 border-mainColor2 text-mainColor1': currentUrl === '{{ route('contact') }}'}"
                    class="block px-3 py-2 text-xl md:p-0 hover:text-mainColor1 hover:bg-gray-200 text-gray-500 md:hover:bg-transparent"
                      ">Liên hệ</a>
            </li>
        </ul>
    </div>
    @auth
    <div x-cloak x-show="openUser" class="absolute flex flex-col right-0 top-14 shadow-lg rounded-md z-50 bg-gray-200">
        <a href={{route('user.info',['infoUser'=> Str::before(Auth::user()->email, '@') ])}} class="flex justify-start items-center p-2 text-gray-500 rounded-md hover:bg-gray-300" wire:navigate><x-carbon-user-filled class="w-5 h-5"/>Trang cá nhân</a>
        {{-- <a href={{route('statistical')}}  class="flex justify-start items-center p-2 text-gray-500 rounded-md hover:bg-gray-300" wire:navigate><x-bi-clipboard-data class="w-5 h-5"/>Thống kê số liệu</a> --}}
        <a href="#" @click="e=>{e.preventDefault();document.getElementById('logout-form').submit()}" class="flex justify-start items-center p-2 rounded-md hover:bg-gray-300 text-gray-500"><x-carbon-logout class="h-5 w-5"/> Đăng xuất</a>
    </div>
    <form id="logout-form" action="{{route('logout')}}" method="POST" class="hidden">
        @csrf
    </form>
    <div x-cloak x-show="showNotifications" class="absolute -bottom-110 right-0 flex flex-col border bg-gray-100 p-2 shadow-md">
        <h1 class="text-2xl font-bold p-2">Thông báo</h1>
        <div class="overflow-y-scroll w-96 h-99">
            {{-- notification items --}}
            <template x-for="notification in notifications" :key="notification.id">
                <a :href="notification.link_target" class="flex items-center h-20 hover:bg-gray-200">
                    <div class="p-2 flex justify-center items-center flex-shrink-0">
                        <img :src="'{{ asset('storage/') }}' + '/' + notification.user.avatar" alt="" class="w-12 h-12 rounded-full">
                    </div>
                    <div>
                        <template x-if="notification.type == 'follow'" >
                            <div class="flex flex-col">
                                <span x-text="notification.user.name + ' đã bắt đầu theo dõi bạn'"></span>
                                <span x-text="notification.formatted_time" class="text-gray-500"></span>
                            </div>
                        </template>
                        {{-- <template x-if="notification.type == 'comment'" >
                            <span x-text="notification.user.name + ' đã bắt đầu theo dõi bạn'"></span>
                            <span x-text="notification.formatted_time"></span>
                        </template> --}}
                    </div>
                </a>
            </template>
        </div>
    </div>
    @endauth 
</div>
@auth
<script>
    window.userID = @json(Auth::user()->id);
</script>
@endauth