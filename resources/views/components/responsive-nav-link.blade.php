@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[var(--primary-green)] text-start text-base font-medium text-[var(--primary-green-dark)] bg-green-50 focus:outline-none focus:text-[var(--primary-green-dark)] focus:bg-[var(--primary-green-light)] focus:border-[var(--primary-green-dark)] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[var(--primary-green)] hover:text-[var(--primary-green-dark)] hover:bg-green-50 hover:border-[var(--primary-green-light)] focus:outline-none focus:text-[var(--primary-green-dark)] focus:bg-green-50 focus:border-[var(--primary-green-light)] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
