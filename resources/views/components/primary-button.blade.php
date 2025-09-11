<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gradient-to-r from-accent-blue to-accent-pink border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-accent-pink focus:ring-offset-2 dark:focus:ring-offset-primary transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
