@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-mainColor1']) }}>
        {{ $status }}
    </div>
@endif
