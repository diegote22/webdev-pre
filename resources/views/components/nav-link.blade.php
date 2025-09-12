@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-accent-blue text-sm font-medium leading-5 text-black dark:text-white focus:outline-none focus:border-accent-pink transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-black dark:text-white hover:text-black dark:hover:text-white hover:border-white/20 focus:outline-none focus:text-black dark:focus:text-white focus:border-white/20 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
