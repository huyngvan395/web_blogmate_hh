<x-app-layout>
  <x-slot name="slot">
    <div x-data="carousel()" x-init="startAutoPlay()" class="relative z-0 mt-16 w-full overflow-hidden">
      <!-- Carousel Items -->
      {{-- <div class="flex transition-transform duration-300" :style="{ transform: `translateX(-${current * 100}%)` }">
        --}}
        <template x-for="(slide, index) in slides" :key="index">
          <div class=" w-full animate-fade" :class="{'block':current===index, 'hidden':current!==index}">
            <div class="bg-after-slide"></div>
            <img x-bind:src="slide.image" :alt="slide.alt" class="w-full h-80 object-cover md:h-120 sm:h-96" />
            <div
              class="absolute transition-opacity duration-300 ease-out opacity-0 left-1/2 top-1/4 sm:top-1/3 -translate-x-1/2 -translate-y-1/4 w-11/12 sm:-translate-x-3/4 md:w-auto mr-auto ml-auto z-10 text-white "
              :class="{'opacity-100': current===index} ">
              <h1 x-text="slide.title"
                class="font-bold font-sans text-xl pb-2 md:pb-6 animate-textShow md:text-6xl sm:text-2xl select-none">
              </h1>
              <p x-text="slide.content" class="font-sans animate-textShow select-none"></p>
            </div>
          </div>
        </template>
        {{--
      </div> --}}

      <!-- Previous Button -->
      <button @click="prev()"
        class="absolute flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 left-1/3 bottom-9 -translate-y-1/2 sm:bottom-1/2 sm:left-2 rounded-full bg-white px-3 py-3 z-20">
        <x-heroicon-s-arrow-left class="w-6 h-8 sm:w-8 sm:h-8 text-mainColor1" />
      </button>

      <!-- Next Button -->
      <button @click="next()"
        class="absolute flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 right-1/3 bottom-9 sm:right-2 sm:bottom-1/2 -translate-y-1/2 rounded-full bg-white px-3 py-3 z-20">
        <x-heroicon-s-arrow-right class="w-6 h-8 sm:w-8 sm:h-8 text-mainColor1" />
      </button>
    </div>

    {{-- card-main--}}
    <div class=" relative -mt-14 md:-mt-24 flex justify-center w-full h-auto z-30">
      <div class="grid md:grid-cols-2 grid-cols-1 w-5/6 h-auto px-10 py-8 bg-white border border-gray-200 rounded-sm">
        <div class="flex justify-center items-center px-8 py-8 md:border-b-0 border-b">
          <div class="flex flex-col justify-center items-center">
            <div class="rounded-full flex justify-center items-center border border-mainColor2 w-24 h-24">
              <x-carbon-report class="w-16 h-16 text-mainColor1" />
            </div>
            <h2 class="sm:text-xl md:text-2xl text-lg font-bold p-1 text-nowrap">Blog</h2>
            <a href="{{route("blog.create")}}" class="flex items-center justify-center text-mainColor1 p-1 text-nowrap">Bắt đầu viết
              <x-heroicon-s-arrow-right class="w-5 h-5 text-mainColor1" />
            </a>
          </div>
        </div>
        <div class="flex justify-center items-center px-8 py-8 md:border-l border-0">
          <div class="flex flex-col justify-center items-center">
            <div class="rounded-full flex justify-center items-center border border-mainColor2 w-24 h-24">
              <x-gmdi-social-distance-s class="w-16 h-16 text-mainColor1" />
            </div>
            <h2 class="sm:text-xl md:text-2xl text-lg font-bold p-1 text-nowrap">Cộng đồng</h2>
            <a href="{{route("blog")}}" class="flex items-center justify-center text-mainColor1 p-1 text-nowrap">Khám phá
              <x-heroicon-s-arrow-right class="w-5 h-5 text-mainColor1" />
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Hero Section -->
    <section class="bg-white py-16 mt-10">
      <div class="container mx-auto px-4 text-center">
          <h2 class="inline-flex text-4xl font-bold text-gray-800 mb-4">Chào mừng đến với <img src="{{asset('images/logo/BlogMate.webp')}}" alt="" class="w-28 h-24 -translate-y-9 pl-3"></h2>
          <p class="text-lg text-gray-600 mb-6">Khám phá những câu chuyện, hiểu biết sâu sắc và ý tưởng thú vị từ mọi người trên khắp thế giới.</p>
          <a href="{{route('blog')}}" class="bg-indigo-500 text-white py-2 px-4 rounded-full shadow-lg hover:bg-indigo-600 transition duration-300">
              Bắt đầu
          </a>
      </div>
  </section>

    {{-- new section --}}
    <div class="container pt-4 mx-auto px-6 py-20 bg-gradient-to-r from-[#5271ff] to-[#05e0e9]">
      <!-- Khơi nguồn cảm hứng -->
      <div class="mt-20 grid md:grid-cols-2 grid-cols-1 gap-16">
          <!-- Text Section -->
          <div class="flex flex-col justify-center text-center md:text-left space-y-6">
              <h1 class="text-6xl font-extrabold text-white leading-tight drop-shadow-lg">
                  Khơi nguồn cảm hứng, chia sẻ đam mê cùng cộng đồng sáng tạo
              </h1>
              <p class="text-xl text-gray-200 max-w-lg mx-auto">
                  Khám phá một cộng đồng nơi bạn có thể kết nối, học hỏi và phát triển các kỹ năng sáng tạo của mình.
              </p>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                  <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                      <h2 class="text-2xl font-semibold text-[#5271ff] mb-4">Kết nối cộng đồng</h2>
                      <p class="text-gray-600">Chia sẻ đam mê và kết nối với những nhà sáng tạo tài năng.</p>
                  </div>
                  <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                      <h2 class="text-2xl font-semibold text-[#5271ff] mb-4">Phát triển kỹ năng</h2>
                      <p class="text-gray-600">Học hỏi và trau dồi các kỹ năng sáng tạo để thành công trong ngành nghề.</p>
                  </div>
                  <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                      <h2 class="text-2xl font-semibold text-[#5271ff] mb-4">Xây dựng dấu ấn</h2>
                      <p class="text-gray-600">Tạo dấu ấn cá nhân với những bài viết độc đáo và phong cách riêng biệt.</p>
                  </div>
              </div>
          </div>
  
          <!-- Image Section -->
          <div class="relative flex justify-center items-center">
              <img src="{{asset('images/image-background-web/blog_template_bg.png')}}" alt="Blog Template Background" class="rounded-2xl shadow-lg transform hover:scale-110 transition-transform duration-500">
              <div class="absolute inset-0 bg-gradient-to-t from-black opacity-50 rounded-2xl"></div>
          </div>
      </div>
  
      <!-- Chat Section -->
      <div class="mt-32 grid md:grid-cols-2 grid-cols-1 gap-16">
          <!-- Text Section -->
          <div class="flex flex-col justify-center text-center md:text-left space-y-6">
              <h1 class="text-6xl font-extrabold text-[#05e0e9] leading-tight drop-shadow-lg">
                  🌟 Chat để Kết Nối & Truyền Cảm Hứng
              </h1>
              <p class="text-xl text-gray-200 max-w-lg mx-auto">
                  Tạo ra không gian để kết nối, thảo luận và lan tỏa những ý tưởng sáng tạo.
              </p>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                  <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                      <h2 class="text-2xl font-semibold text-[#05e0e9] mb-4">Thảo luận sáng tạo</h2>
                      <p class="text-gray-600">Chia sẻ ý tưởng và kinh nghiệm sáng tạo trong môi trường cởi mở.</p>
                  </div>
                  <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                      <h2 class="text-2xl font-semibold text-[#05e0e9] mb-4">Kết nối cộng đồng</h2>
                      <p class="text-gray-600">Tìm kiếm và kết nối với những người có cùng đam mê và mục tiêu.</p>
                  </div>
                  <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                      <h2 class="text-2xl font-semibold text-[#05e0e9] mb-4">Tạo cơ hội mới</h2>
                      <p class="text-gray-600">Mở rộng mạng lưới của bạn và tìm kiếm cơ hội hợp tác mới.</p>
                  </div>
              </div>
              <h1 class="text-5xl font-extrabold text-[#05e0e9] mt-16 drop-shadow-lg">
                  🔧 Cách Tham Gia Chat
              </h1>
              <ul class="space-y-4 text-lg text-gray-200 max-w-lg mx-auto">
                  <li class="flex items-center">
                      <x-heroicon-o-ticket class="text-[#05e0e9] w-6 h-6 mr-4" /> 
                      Đăng nhập vào tài khoản của bạn để tham gia cộng đồng.
                  </li>
                  <li class="flex items-center">
                      <x-heroicon-o-ticket class="text-[#05e0e9] w-6 h-6 mr-4" /> 
                      Theo dõi các tác giả và nhà sáng tạo bạn yêu thích.
                  </li>
                  <li class="flex items-center">
                      <x-heroicon-o-ticket class="text-[#05e0e9] w-6 h-6 mr-4" /> 
                      Bắt đầu trò chuyện ngay lập tức bằng một cú nhấp chuột!
                  </li>
              </ul>
          </div>
  
          <!-- Image Section -->
          <div class="relative flex justify-center items-center">
              <img src="{{asset('images/image-background-web/chat_bg.gif')}}" alt="Chat Background" class="rounded-2xl shadow-lg transform hover:scale-110 transition-transform duration-500">
              <div class="absolute inset-0 bg-gradient-to-t from-black opacity-50 rounded-2xl"></div>
          </div>
      </div>
  </div>

  {{-- <!-- Featured Blogs -->
  <section id="blogs" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">Blog nổi bật</h3>
        <div x-data="{ currentIndex: 0 }" class="relative">
            <div class="flex space-x-6 overflow-hidden">
                <!-- Blog Card -->
                <template x-for="(blog, index) in [{title: 'Blog Title 1', description: 'Lorem ipsum dolor sit amet.'}, {title: 'Blog Title 2', description: 'Consectetur adipiscing elit.'}, {title: 'Blog Title 3', description: 'Sed do eiusmod tempor incididunt.'}]" :key="index">
                    <div class="min-w-[300px] bg-white rounded-lg shadow-md p-4 flex flex-col items-center text-center transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                        <img src="https://via.placeholder.com/300x200" alt="Blog Image" class="w-full rounded-md mb-4">
                        <h4 class="text-lg font-bold text-gray-800" x-text="blog.title"></h4>
                        <p class="text-gray-600 mt-2" x-text="blog.description"></p>
                    </div>
                </template>
            </div>
            <div class="mt-4 flex justify-center items-center gap-2 text-center">
              <button @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : 2" class="flex justify-center items-center bg-indigo-500 text-white p-4 rounded-full"><x-bi-chevron-left /></button>
              <button @click="currentIndex = (currentIndex < 2) ? currentIndex + 1 : 0" class="flex justify-center items-center bg-indigo-500 text-white p-4 rounded-full"><x-bi-chevron-right /></button>
          </div>
        </div>
    </div>
</section>

  <!-- Featured Users Section -->
  <section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h3 class="text-3xl font-bold text-gray-800 mb-8 text-center">Người dùng nổi bật</h3>
        <div x-data="{ currentIndex: 0 }" class="relative">
            <div class="flex space-x-6 overflow-hidden">
                <!-- User Card -->
                <template x-for="(user, index) in [{name: 'User Name 1', description: 'Lorem ipsum dolor.'}, {name: 'User Name 2', description: 'Consectetur adipiscing elit.'}, {name: 'User Name 3', description: 'Sed do eiusmod tempor.'},{name: 'User Name 1', description: 'Lorem ipsum dolor.'}, {name: 'User Name 2', description: 'Consectetur adipiscing elit.'}, {name: 'User Name 3', description: 'Sed do eiusmod tempor.'}]" :key="index">
                    <div class="min-w-[300px] bg-gray-100 rounded-lg shadow-md p-6 flex flex-col items-center text-center transition-transform duration-500" :style="`transform: translateX(-${currentIndex * 100}%)`">
                        <img src="https://via.placeholder.com/100" alt="User Avatar" class="w-24 h-24 rounded-full mb-4">
                        <h4 class="text-lg font-bold text-gray-800" x-text="user.name"></h4>
                        <p class="text-gray-600" x-text="user.description"></p>
                    </div>
                </template>
            </div>
            <div class="mt-4 flex justify-center items-center gap-2 text-center">
                <button @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : 2" class="flex justify-center items-center bg-indigo-500 text-white p-4 rounded-full"><x-bi-chevron-left /></button>
                <button @click="currentIndex = (currentIndex < 2) ? currentIndex + 1 : 0" class="flex justify-center items-center bg-indigo-500 text-white p-4 rounded-full"><x-bi-chevron-right /></button>
            </div>
        </div>
    </div>
</section> --}}

 <!-- Statistics Section -->
 <section class="py-16 bg-gray-50">
  <div class="container mx-auto px-4 text-center">
      <h3 class="text-3xl font-bold text-gray-800 mb-6">Thành tựu</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
          <!-- Blogs Count -->
          <div class="bg-white rounded-lg shadow-md p-6">
              <h4 class="text-4xl font-bold text-indigo-500">{{$blogCount}}</h4>
              <p class="text-gray-600 mt-2">Blog đã đăng tải</p>
          </div>
          <!-- Users Count -->
          <div class="bg-white rounded-lg shadow-md p-6">
              <h4 class="text-4xl font-bold text-indigo-500">{{$userCount}}</h4>
              <p class="text-gray-600 mt-2">Người dùng</p>
          </div>
      </div>
  </div>
</section>

  <!-- About Section -->
  <section id="about" class="py-16 bg-white">
      <div class="container mx-auto px-4 text-center">
          <h3 class="text-3xl font-bold text-gray-800 mb-6">Về chúng tôi</h3>
          <p class="inline-flex text-gray-600 max-w-3xl mx-auto">Tại <img src="{{asset('images/logo/BlogMate.webp')}}" alt="" class="w-20 h-16 -translate-y-6">, chúng tôi mong muốn kết nối mọi người thông qua những câu chuyện và ý tưởng. Nền tảng của chúng tôi trao quyền cho các cá nhân thể hiện sự sáng tạo, chia sẻ kiến ​​thức và xây dựng mối quan hệ có ý nghĩa với những người khác trên khắp thế giới.</p>
      </div>
  </section>


    <script>
      function carousel() {
              return {
                current: 0,
                slides: [
                  { image: '{{ asset('images/image-background-web/infomation.jpg') }}', alt: 'Slide 1', title: 'Những góc nhìn mới lạ và độc đáo trên các lĩnh vực', content: 'Từ công nghệ, du lịch, sáng tạo đến phong cách sống – BlogMateHH luôn có không gian cho mọi ý tưởng của bạn' },
                  { image: '{{ asset('images/image-background-web/eviroment.jpg') }}', alt: 'Slide 2', title: 'Khám phá những câu chuyện thú vị và truyền cảm hứng', content: 'Tìm đọc các bài viết được yêu thích nhất từ cộng đồng, khám phá những điều thú vị và hấp dẫn, lan tỏa cảm hứng và năng lượng tích cực mỗi ngày' },
                  { image: '{{ asset('images/image-background-web/economic.jpg') }}', alt: 'Slide 3', title: 'Biến những ý tưởng của bạn thành những giá trị', content: 'Chia sẻ bài viết của bạn để không chỉ kết nối mà còn gây ấn tượng với cộng đồng yêu thích viết lách' },
                ],
                interval: null,
                next() {
                  this.stopAutoPlay();
                  this.current = (this.current + 1) % this.slides.length;
                  this.startAutoPlay();
                },
                prev() {
                  this.stopAutoPlay();
                  this.current = (this.current - 1 + this.slides.length) % this.slides.length;
                  this.startAutoPlay();
                },
                startAutoPlay() {
                  this.interval = setInterval(() => {
                    this.next();
                  }, 5000); 
                },
                stopAutoPlay() {
                  clearInterval(this.interval);
                },
              };
            }
    </script>
  </x-slot>
</x-app-layout>