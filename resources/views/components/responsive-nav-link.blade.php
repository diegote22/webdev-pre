@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-accent-blue text-start text-base font-medium text-light-gray bg-accent-blue/10 focus:outline-none focus:bg-accent-blue/20 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-light-gray/80 hover:text-light-gray hover:bg-white/5 focus:outline-none focus:bg-white/5 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
