<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'm-5 h-10 bg-violet-900 text-white']) }}
>
    {{ $slot }}
</button>
