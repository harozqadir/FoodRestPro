@props(['label' => 'دروستکردن'])

<button type="submit" {{ $attributes->merge(['class' => 'btn btn-success rounded-pill px-4']) }}>
    {{ $label }}
</button>