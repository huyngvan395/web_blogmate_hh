<x-sub-layout>
    <x-slot name="slot">
        <div class="relative flex items-center w-full md:h-100 sm:h-96 h-80" style="background: url('{{asset('images/image-background-web/blog_bg_ini.jpeg')}}');background-size: cover;">
            <div class="w-1/2 flex items-center">
                <div class="flex flex-col">
                    <h1 class="w-full text-wrap text-8xl font-bold translate-x-36 text-white p-4">
                        CÂU CHUYỆN, KIẾN THỨC & TRẢI NGHIỆM
                    </h1>
                    <p class="w-full text-3xl translate-x-36 text-white p-4">
                        Nơi để đọc, chia sẻ kiến thức và trò chuyện với mọi người
                    </p>
                    <div class="translate-x-36 p-4">
                        <button x-data @click="window.location.href='{{ route('blog') }}'" class="flex items-center justify-start p-4 text-2xl bg-sky-500 text-white rounded-lg hover:bg-sky-700">
                            Bắt đầu ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-sub-layout>