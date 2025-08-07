@props(['title', 'name', 'type' => 'text', 'dt' => false])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label fw-semibold">{{ ucfirst($title) }}</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        class="form-control rounded-3 shadow-sm @error($name) is-invalid @enderror" 
        value="{{ old($name, $dt ? $dt->$name : '') }}"
        {{ $type === 'password' ? '' : 'autocomplete=off' }}
    >
    @error($name)
    <small class="text-danger" dir="rtl">{{ $message }}</small>
    @enderror
</div>
