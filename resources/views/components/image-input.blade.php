<div>
    <!-- Because you are alive, everything is possible. - Thich Nhat Hanh -->
</div>{{-- filepath: resources/views/components/image-input.blade.php --}}
@props([
    'name' => 'image',
    'label' => 'وێنەی پۆل',
    'value' => null,
])

<div class="col-md-6" dir="rtl">
    <label for="{{ $name }}" class="form-label fw-semibold" style="font-family: 'RudawRegular', sans-serif;">{{ $label }}</label>
    <div id="drop-area-{{ $name }}" class="border rounded-3 p-4 text-center bg-light"
         style="cursor: pointer; min-height: 100px; position: relative;"
         onclick="document.getElementById('{{ $name }}').click();"
         ondragover="event.preventDefault(); this.classList.add('border-primary');"
         ondragleave="event.preventDefault(); this.classList.remove('border-primary');"
         ondrop="handleDrop(event, '{{ $name }}')">
        <input 
            type="file" 
            name="{{ $name }}" 
            id="{{ $name }}" 
            class="d-none @error($name) is-invalid @enderror"
            accept="image/*"
            onchange="previewImage(event, '{{ $name }}_preview')"
        >
        <div id="{{ $name }}_preview" class="mb-2">
            @if($value)
                <img src="{{ asset('sub-categories-image/' . $value) }}" alt="وێنەی ئێستا" class="img-thumbnail" style="max-width: 120px;">
            @else
                <span class="text-muted small">هیچ وێنەیەکی هەلبژێردراو نییە</span>
            @endif
        </div>
        <div class="text-muted small">دەتوانیت وێنە بکەیتە ناو یان کلیک بکە بۆ هەلبژاردنی وێنە</div>
    </div>
    @error($name)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>