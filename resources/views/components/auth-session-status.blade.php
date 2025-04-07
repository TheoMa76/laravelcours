@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-[var(--primary-green)]']) }}>
        {{ $status }}
    </div>
@endif
