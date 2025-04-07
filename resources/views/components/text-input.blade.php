@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[var(--primary-gray)] focus:border-[var(--primary-green)] focus:ring-[var(--primary-green)] rounded-md shadow-sm']) }}>
