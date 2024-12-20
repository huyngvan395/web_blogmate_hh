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
        <x-heroicon-s-arrow-left class="w-6 h-8 sm:w-8 sm:h-8 text-sky-500" />
      </button>

      <!-- Next Button -->
      <button @click="next()"
        class="absolute flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 right-1/3 bottom-9 sm:right-2 sm:bottom-1/2 -translate-y-1/2 rounded-full bg-white px-3 py-3 z-20">
        <x-heroicon-s-arrow-right class="w-6 h-8 sm:w-8 sm:h-8 text-sky-500" />
      </button>

      <!-- Indicator Dots -->
      {{-- <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <template x-for="(slide, index) in slides" :key="index">
          <div :class="{ 'bg-emerald-700': current === index, 'bg-white': current !== index }"
            class="w-3 h-3 rounded-full cursor-pointer" @click="current = index"></div>
        </template>
      </div> --}}
    </div>

    {{-- card-main--}}
    <div class=" relative -mt-14 md:-mt-24 flex justify-center w-full h-auto z-30">
      <div class="grid md:grid-cols-2 grid-cols-1 w-5/6 h-auto px-10 py-8 bg-white border border-gray-200 rounded-sm">
        {{-- <div class="flex justify-center items-center px-8 py-8 md:border-0 border-b">
          <div class="flex flex-col justify-center items-center">
            <div class="rounded-full flex justify-center items-center border border-sky-500 w-24 h-24">
              <x-gmdi-volunteer-activism-o class="w-16 h-16 text-sky-500" />
            </div>
            <h2 class="sm:text-xl md:text-2xl text-lg font-bold p-1 text-nowrap">Tình nguyện viên</h2>
            <a href="{{route("volunteer")}}" class="flex items-center justify-center text-sky-500 p-1 text-nowrap">Tham
              gia
              <x-heroicon-s-arrow-right class="w-5 h-5 text-sky-500" />
            </a>
          </div>
        </div> --}}
        <div class="flex justify-center items-center px-8 py-8 md:border-b-0 border-b">
          <div class="flex flex-col justify-center items-center">
            <div class="rounded-full flex justify-center items-center border border-sky-500 w-24 h-24">
              <x-carbon-report class="w-16 h-16 text-sky-500" />
            </div>
            <h2 class="sm:text-xl md:text-2xl text-lg font-bold p-1 text-nowrap">Blog</h2>
            <a href="{{route("blog.create")}}" class="flex items-center justify-center text-sky-500 p-1 text-nowrap">Bắt đầu viết
              <x-heroicon-s-arrow-right class="w-5 h-5 text-sky-500" />
            </a>
          </div>
        </div>
        <div class="flex justify-center items-center px-8 py-8 md:border-l border-0">
          <div class="flex flex-col justify-center items-center">
            <div class="rounded-full flex justify-center items-center border border-sky-500 w-24 h-24">
              <x-gmdi-social-distance-s class="w-16 h-16 text-sky-500" />
            </div>
            <h2 class="sm:text-xl md:text-2xl text-lg font-bold p-1 text-nowrap">Cộng đồng</h2>
            <a href="{{route("blog")}}" class="flex items-center justify-center text-sky-500 p-1 text-nowrap">Khám phá
              <x-heroicon-s-arrow-right class="w-5 h-5 text-sky-500" />
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- <div class="grid md:grid-cols-2 grid-cols-1 mt-10 px-10 gap-10">
      <div>
        <img src="{{asset(" images/image-background-web/bg1_home.png")}}" alt="bg1">
      </div>
      <div>
        <h2 class="md:text-5xl text-lg font-bold leading-loose pb-5 ">Bảo Vệ Trái Đất Chống Lại Biến Đổi Khí Hậu</h2>
        <p class="text-lg leading-loose text-gray-500 pb-4">Hãy cùng chung tay bảo vệ môi trường và chống lại biến đổi
          khí hậu. Mỗi hành động nhỏ đều góp phần tạo nên sự thay đổi lớn cho hành tinh của chúng ta. Cùng nhau bảo vệ
          môi trường xanh - sạch - đẹp, vì một tương lai bền vững.</p>
        <ul class="flex flex-col gap-8">
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Chung tay trồng cây gây rừng, cải thiện môi trường sống
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Giảm thiểu sử dụng nhựa và rác thải khó phân hủy
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Sử dụng năng lượng tái tạo và tiết kiệm tài nguyên
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Thúc đẩy lối sống thân thiện với môi trường
          </li>
        </ul>
      </div>
    </div> --}}

    {{-- blog-bg --}}
    <div class="grid md:grid-cols-2 grid-cols-1 mt-16 px-10 gap-10">
      <div>
        <h1 class="md:text-5xl text-lg font-bold leading-loose pb-5">
          Khơi nguồn cảm hứng, chia sẻ đam mê cùng cộng đồng sáng tạo
        </h1>
        <ul class="flex flex-col gap-2">
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Kết nối với cộng đồng sáng tạo: Chia sẻ bài viết của bạn với hàng ngàn người có cùng sở thích, đam mê.
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Phát triển kỹ năng viết lách: Tính năng hỗ trợ soạn thảo phong phú, từ cơ bản đến nâng cao, giúp bạn dễ dàng tạo nên những bài viết chất lượng.
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Tạo dấu ấn cá nhân: Tùy chỉnh bài viết với hình ảnh, video, và định dạng văn bản để thể hiện phong cách riêng.
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Giao lưu, học hỏi: Nhận phản hồi, bình luận từ độc giả và khám phá thêm nhiều góc nhìn mới mẻ từ cộng đồng.
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Xây dựng thương hiệu cá nhân: Biến blog của bạn thành một kênh để khẳng định chuyên môn và tạo dựng hình ảnh chuyên nghiệp.
          </li>
        </ul>
      </div>
      <div>
        <img src="{{asset("images/image-background-web/blog_template_bg.png")}}" alt="bg1">
      </div>
    </div>

    {{-- chat-bg --}}
    <div class="grid md:grid-cols-2 grid-cols-1 mt-16 px-10 gap-10">
      <div>
        <img src="{{asset("images/image-background-web/chat_bg.gif")}}" alt="bg1">
      </div>
      <div>
        <h1 class="md:text-5xl text-lg font-bold leading-loose pb-5">
          🌟 Chat để Kết Nối & Truyền Cảm Hứng
        </h1>
        <ul class="flex flex-col gap-2">
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Thảo luận sâu hơn về những bài viết, câu chuyện, hoặc ý tưởng mà bạn yêu thích.
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Học hỏi từ cộng đồng: Chia sẻ kinh nghiệm, góc nhìn sáng tạo, hoặc đặt câu hỏi trực tiếp đến tác giả và các nhà sáng tạo khác.
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Kết nối không giới hạn: Tìm kiếm những người cùng đam mê, trao đổi để mở rộng tầm nhìn và kiến thức.
          </li>
        </ul>
        <h1 class="md:text-5xl text-lg font-bold leading-loose pb-5">
          🔧 Cách Tham Gia Chat
        </h1>
        <ul class="flex flex-col gap-2">
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Đăng nhập vào tài khoản của bạn để tham gia cộng đồng.
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Đọc hay theo dõi các nhà sáng tạo, các tác giả trên nền tảng
          </li>
          <li class="flex items-center text-lg gap-5 text-gray-500">
            <x-heroicon-o-ticket class="text-sky-500 w-4 h-4" /> Bắt đầu trò chuyện bằng cách nhấn vào "Nhắn tin" với tác giả đó chỉ một cú nhấp chuột để kết nối ngay!
          </li>
        </ul>
      </div>
    </div>

    {{-- statistical --}}
    <div class="flex w-full justify-center items-center sm:px-8 mt-10 bg-sky-500">
      <div class="grid md:grid-cols-2 grid-cols-1 gap-5 py-4">
        <div class="flex justify-center items-center w-80 text-white p-10 rounded-lg border bg-white/15 backdrop-blur-md">
          <x-heroicon-s-user-group class="w-40 h-40"/>
          <div class="flex flex-col p-4">
            <h1 class="text-5xl font-bold">{{$userCount}}</h1>
            <h1 class="text-lg ">Số lượng người dùng</h1>
          </div>
        </div>
        <div class="flex justify-center items-center w-80 text-white p-10 rounded-lg border bg-white/15 backdrop-blur-md">
          <x-si-blogger class="w-40 h-40"/>
          <div class="flex flex-col p-4">
            <h1 class="text-5xl font-bold">{{$blogCount}}</h1>
            <h1 class="text-lg ">Số lượng blog</h1>
          </div>
        </div>
      </div>
    </div>


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