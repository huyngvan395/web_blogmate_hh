<x-sub-layout>
    <x-slot name="slot">
        <div x-data='dataCreateBlog(@json($categories))'>
            <div class="mt-32 mx-0 md:mx-28 ">
                <form action="{{route('blog.store')}}" method="POST" class="" >
                    @csrf
                    <div class="flex flex-col gap-2">
                        <x-text-input id="title" name="title" class="border-none text-3xl" x-model="title" placeholder="Tiêu đề"></x-text-input>
                    </div>
                    <div class="relative mt-4">
                        <input type="text" x-model="search" name="category_name" placeholder="Tìm thể loại..." 
                            class="w-full border rounded-lg px-4 py-2" 
                            x-on:focus="dropdownOpen = true" x-on:click.outside="dropdownOpen = false">
                        <ul class="absolute left-0 mt-1 bg-white border rounded-lg shadow w-full z-10" x-show="dropdownOpen && search.length > 0">
                            <template x-for="category in categories.filter(c => c.name.toLowerCase().includes(search.toLowerCase()))" :key="category.id">
                                <li class="p-2 hover:bg-gray-100 cursor-pointer" 
                                    @click="selectedCategory = category.id; search = category.name; dropdownOpen = false">
                                    <span x-text="category.name"></span>
                                </li>
                            </template>
                            <li x-show="!categories.filter(c => c.name.toLowerCase().includes(search.toLowerCase())).length" 
                                class="p-2 text-gray-500">
                                Không tìm thấy thể loại
                            </li>
                        </ul>
                        <input type="hidden" name="category_id" x-model="selectedCategory">
                    </div>
                    <div class="flex flex-col mt-4">
                        <trix-editor input="content_blog" x-on:trix-change="content = $event.target.value"
                        class="trix-content bg-white border-none overflow-y-scroll h-96" placeholder="Hãy viết gì đó"></trix-editor>
                        <input type="hidden" id="content_blog" x-model="content" name="content" value="">
                    </div>
                    <x-primary-button type="submit" class="mt-4" x-bind:disabled="!title.trim() || !content.trim()"
                        x-bind:class="!title.trim() || !content.trim() ? 'opacity-50 cursor-not-allowed' : 'opacity-100'"
                        x-bind:title="!title.trim() || !content.trim() ? 'Vui lòng viết nội dung và tiêu đề blog' : ''">
                        <svg id="loading-spinner" class="hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Đăng
                    </x-primary-button>
                </form>
            </div>
        </div>
    </x-slot>
</x-sub-layout>
