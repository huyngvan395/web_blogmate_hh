<footer class="mt-10 px-16 pt-12">
    <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1">
        <div class="flex flex-col justify-center mb-3 md:mb-0">
            <a href={{route("home")}} class=" flex items-center space-x-3" wire:navigate>
                <img src="{{ asset('images/logo/logo_blogmate.png')}}" class="h-6 sm:h-12" alt="Logo"/>
                <span class="self-center text-xl sm:text-2xl md:text-4xl font-semibold whitespace-nowrap text-sky-500">Blogmate HH</span>
            </a>
            <div class="p-3">
                <p class="text-lg">
                    Người bạn đồng hành hoàn hảo, nơi kết nối, chia sẻ và lan tỏa đam mê qua từng câu chữ
                </p>
            </div>
        </div>
        <div class="flex md:justify-center">
            <ul>
                <h3 class="md:text-3xl text-xl font-bold pb-2">Khám phá</h3>
                <li class="py-2"><a href="{{route("about_us")}}" class="text-base md:text-lg text-gray-500">Về chúng tôi</a></li>
                <li class="py-2"><a href="{{route("project")}}" class="text-base md:text-lg text-gray-500">Dự án</a></li>
                <li class="py-2"><a href="{{route("blog")}}" class="text-base md:text-lg text-gray-500">Blog</a></li>
                <li class="py-2"><a href="{{route("contact")}}" class="text-base md:text-lg text-gray-500">Liên hệ</a></li>
            </ul>
        </div>
        <div class="flex md:justify-center">
            <ul>
                <h3 class="md:text-3xl text-xl font-bold pb-2">Thông tin chúng tôi</h3>
                <li class="flex py-2">
                    <div class="flex md:justify-center items-center ">
                        <x-ionicon-location class="w-6 h-6 mr-2 text-sky-500"/>
                        <span class="text-base md:text-lg text-gray-500">Vị trí</span>
                    </div>
                </li>
                <li class="flex py-2">
                    <div class="flex md:justify-center items-center ">
                        <x-ionicon-mail-outline class="w-6 h-6 mr-2 text-sky-500"/>
                        <span class="text-base md:text-lg text-gray-500">Email</span>
                    </div>
                </li>
                <li class="flex py-2">
                    <div class="flex md:justify-center items-center ">
                        <x-heroicon-o-phone-arrow-down-left class="w-6 h-6 mr-2 text-sky-500"/>
                        <span class="text-base md:text-lg text-gray-500">Điện thoại</span>
                    </div>
                </li>
                <li></li>
            </ul>
        </div>
    </div>
</footer>