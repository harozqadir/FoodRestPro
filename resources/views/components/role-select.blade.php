@props(['role'])

@php
    $roles = [
        1 => 'Admin',
        2 => 'Server',
        3 => 'Chief',
        4 => 'Casher',
    ];
@endphp

<div class="mb-3">
<label for="role" class="form-label fw-semibold"></label>
    <select name="role" class="form-select">
@foreach([1 => __('words.Admin'), 2 => __('words.Server'), 3 => __('words.Chef'), 4 => __('words.Casher')] as $value => $label)
        <option value="{{ $value }}" {{ $role == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
    @error('role')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
