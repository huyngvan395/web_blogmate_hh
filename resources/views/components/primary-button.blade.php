<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-mainColor1 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest cursor-pointer hover:bg-mainColor1_600 focus:bg-mainColor1_600 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-mainColor1 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
