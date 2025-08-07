{{-- filepath: resources/views/components/sub-category-dropdown.blade.php --}}
@props([
    'subCategories' => [],
    'selected' => null,
    'name' => 'sub_category_id',
    'label' => __('words.SubCategory Name'),
    'placeholder' => __('words.Select SubCategory Name'),
])

<div class="col-md-6">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-select">
        <option value="" disabled {{ empty($selected) ? 'selected' : '' }}>{{ $placeholder }}</option>
        @foreach ($subCategories as $subCategory)
            <option value="{{ $subCategory->id }}" {{ $selected == $subCategory->id ? 'selected' : '' }}>
                {{ $subCategory->name_en }}
            </option>
        @endforeach
    </select>
    @error($name)
        <div class="text-danger mt-1">{{ $message }}</div>
    @enderror
</div>