@props(['value'])

<label {{ $attributes->merge(['class' => 'mb-2 block font-bold text-lg text-indigo-800']) }}>
    {{ $value ?? $slot }}
</label>
