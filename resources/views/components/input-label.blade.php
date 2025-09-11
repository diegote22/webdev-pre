@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-light-gray/80']) }}>
    {{ $value ?? $slot }}
</label>
