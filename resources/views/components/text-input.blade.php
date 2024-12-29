@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-mainColor1 focus:ring-mainColor1 rounded-md shadow-sm']) }}>
