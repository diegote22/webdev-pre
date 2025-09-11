@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-white/20 bg-primary/50 text-light-gray focus:border-accent-blue focus:ring-accent-blue rounded-md shadow-sm']) }}>
