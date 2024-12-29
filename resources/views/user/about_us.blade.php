<x-app-layout>
    <x-slot name="slot">
        <div class="bg-white mt-24">
            <!-- Header Section -->
            <header class="bg-white text-[#5271ff] py-10">
                <div class="container mx-auto text-center">
                    <h1 class="flex justify-center items-center gap-1 text-5xl font-bold">Chào mừng đến với <img src="{{asset('images/logo/BlogMate.webp')}}" alt="" class="w-44 h-40 -translate-y-4"></h1>
                    <p class="mt-4 text-lg">Một không gian cho cảm hứng, ý tưởng và sự sáng tạo.</p>
                </div>
            </header>

            <!-- Introduction Section -->
            <section class="py-20">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row items-start">
                        <div class="md:w-1/2">
                            <h2 class="text-5xl font-bold mb-4 text-[#5271ff] py-10">Về chúng tôi</h2>
                            <p class="flex justify-center items-centertext-lg leading-relaxed text-[#05e0e9] text-2xl">
                                <img src="{{asset('images/logo/BlogMate.webp')}}" alt="" class="w-44 h-40 -translate-y-4"> là một không gian trực tuyến nơi cảm hứng, ý tưởng và sự sáng tạo kết nối không giới hạn. Chúng tôi tin rằng mọi người đều có một câu chuyện để kể và những giấc mơ để chia sẻ.
                            </p>
                        </div>
                        <div class="md:w-1/2 mt-8 md:mt-0">
                            <img src="{{asset('images/logo/bg-image-about_us.jpg')}}" alt="BlogMate" class="rounded-lg shadow-lg">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section class="bg-gray-100 text-white py-20">
                <div class="container mx-auto px-4">
                    <h2 class="text-4xl font-bold text-[#5271ff] text-center mb-8">Chức năng của chúng tôi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="bg-[#05e0e9] p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-semibold mb-2">Tự do sáng tạo</h3>
                            <p>Chúng tôi khuyến khích mọi hình thức thể hiện bản thân, từ viết blog đến trò chuyện.</p>
                        </div>
                        <div class="bg-[#05e0e9] p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-semibold mb-2">Kết nối có ý nghĩa</h3>
                            <p>Xây dựng những mối quan hệ đáng nhớ và học hỏi lẫn nhau.</p>
                        </div>
                        <div class="bg-[#05e0e9] p-6 rounded-lg shadow-lg">
                            <h3 class="text-xl font-semibold mb-2">Quyền riêng tư và bảo mật</h3>
                            <p>Quyền riêng tư của bạn là ưu tiên hàng đầu của chúng tôi. Chia sẻ tự tin trong một môi trường an toàn.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Call to Action Section -->
            <section class="py-20">
                <div class="container mx-auto text-center">
                    <h2 class="text-4xl font-bold mb-4">Tham gia với chúng tôi!</h2>
                    <p class="mb-8">Trở thành một phần của cộng đồng sôi động của chúng tôi và bắt đầu chia sẻ câu chuyện của bạn.</p>
                    <a href="{{route('blog.create')}}" class="bg-[#5271ff] text-white py-3 px-6 rounded-lg shadow-lg hover:bg-[#05e0e9] transition duration-300">Bắt đầu</a>
                </div>
            </section>
        </div>
    </x-slot>
</x-app-layout>