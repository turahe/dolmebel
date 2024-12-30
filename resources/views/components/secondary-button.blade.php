<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'm-5 h-10 bg-yellow-500 text-white']) }}
>
    {{ $slot }}
</button>
