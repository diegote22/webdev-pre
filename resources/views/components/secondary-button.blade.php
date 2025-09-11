<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-transparent border border-white/20 rounded-md font-semibold text-xs text-light-gray uppercase tracking-widest shadow-sm hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-accent-blue focus:ring-offset-2 dark:focus:ring-offset-primary disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
