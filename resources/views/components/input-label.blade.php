@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[var(--primary-black)]']) }}>
    {{ $value ?? $slot }}
</label>
