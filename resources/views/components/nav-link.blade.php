@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[var(--primary-green)] text-sm font-medium leading-5 text-[var(--primary-black)] focus:outline-none focus:border-[var(--primary-green-dark)] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[var(--primary-gray-dark)] hover:text-[var(--primary-black)] hover:border-[var(--primary-green-light)] focus:outline-none focus:text-[var(--primary-green-dark)] focus:border-[var(--primary-green-light)] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
