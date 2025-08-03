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
    <label for="role" class="form-label fw-semibold">Role</label>
    <select name="role" class="form-select">
    @foreach([1 => 'Admin', 2 => 'Server', 3 => 'Chief', 4 => 'Casher'] as $value => $label)
        <option value="{{ $value }}" {{ $role == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
    @error('role')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
