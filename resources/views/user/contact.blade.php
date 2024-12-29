<x-app-layout>
    <x-slot name="slot">
        <div class="bg-white mt-24">
            <!-- Header Section -->
            <div class="bg-[#5271ff] text-white py-10 ">
                <div class="container mx-auto text-center">
                    <h1 class="text-5xl font-bold">Liên Hệ Chúng Tôi</h1>
                    <p class="mt-4 text-lg">Chúng tôi rất mong nhận được phản hồi từ bạn!</p>
                </div>
            </div>

            <!-- Contact Information Section -->
            <section class="py-20">
                <div class="container mx-auto px-4">
                    <h2 class="text-4xl font-bold text-center mb-8">Liên Hệ Với Chúng Tôi</h2>
                    <div class="flex flex-col md:flex-row justify-around gap-10">
                        <div class="bg-[#05e0e9] text-white p-6 rounded-lg shadow-lg mb-6 md:mb-0 md:w-1/3">
                            <h3 class="text-2xl font-semibold mb-4">Email</h3>
                            <p>huynv.23ite@vku.udn.vn</p>
                            <p>hongnt.23ite@vku.udn.vn</p>
                        </div>
                        <div class="bg-[#05e0e9] text-white p-6 rounded-lg shadow-lg mb-6 md:mb-0 md:w-1/3">
                            <h3 class="text-2xl font-semibold mb-4">Điện Thoại</h3>
                            <p>(+84) 328 166 890</p>
                        </div>
                        <div class="bg-[#05e0e9] text-white p-6 rounded-lg shadow-lg md:w-1/3">
                            <h3 class="text-2xl font-semibold mb-4">Địa Chỉ</h3>
                            <p>450 Trần Đại Nghĩa, Ngũ Hành Sơn, Đà Nẵng, Việt Nam</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Contact Form Section -->
            <section class="py-20 bg-gray-100">
                <div class="container mx-auto px-4">
                    <h2 class="text-4xl font-bold text-center mb-8">Gửi Tin Nhắn Cho Chúng Tôi</h2>
                    <form class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Họ Tên</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Họ Tên Của Bạn" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="Email Của Bạn" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="message">Tin Nhắn</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="message" rows="4" placeholder="Tin Nhắn Của Bạn" required></textarea>
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-[#5271ff] hover:bg-[#05e0e9] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Gửi Tin Nhắn
                            </button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Map Section -->
            <section class="py-20">
                <div class="container mx-auto px-4">
                    <h2 class="text-4xl font-bold text-center mb-8">Tìm Chúng Tôi Tại Đây</h2>
                    <div class="overflow-hidden rounded-lg shadow-lg">
                        <iframe class="w-full" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d21698.946386204512!2d108.24347424858638!3d15.968266518915218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1734992437968!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </section>
        </div>
    </x-slot>
</x-app-layout>