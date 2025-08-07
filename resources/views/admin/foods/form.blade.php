@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Advanced Page Header -->
    <x-restaurant-header
        :title="__('words.Manage Foods')"
        :subtitle="__('words.Restaurant Foods & Management')"
        :icon="'fas fa-utensils'"
        :action-route="route('admin.foods.index')"
        :action-text="__('words.Back')"
        :action-icon="'fas fa-arrow-left me-2 fs-4'"
    />

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form   
                id="filtersForm"
                enctype="multipart/form-data"
                action="{{ isset($data) ? route('admin.foods.update', ['food' => $data->id]) : route('admin.foods.store') }}" 
                method="POST" 
                class="row g-4">
                @csrf
                @isset($data)
                    @method('PUT')
                @endisset

                <!-- Name Kurdish -->
                <div class="col-md-6">
                    <label for="name_ckb">{{ __('words.Name Kurdish') }}</label>
                    <x-input title="" name="name_ckb" type="text" :dt="isset($data) ? $data : false" />
                </div>

                <!-- Name Arabic -->
                <div class="col-md-6">
                    <label for="name_ar">{{ __('words.Name Arabic') }}</label>
                    <x-input title="" name="name_ar" type="text" :dt="isset($data) ? $data : false" />
                </div>

                <!-- Name English -->
                <div class="col-md-6">
                    <label for="name_en">{{ __('words.Name English') }}</label>
                    <x-input title="" name="name_en" type="text" :dt="isset($data) ? $data : false" />
                </div>

                {{-- Price --}}
                <div class="col-md-6">
                    <label for="price">{{ __('words.Price') }}</label>
                    <x-input title="" name="price" type="number" :dt="isset($data) ? $data : false" />
                </div>

                <!-- Sub-category Dropdown (Floating Style) -->
                <div class="col-md-6">
                    <label for="sub_category_id" class="form-label">{{ __('words.SubCategory Name') }}</label>
                    <select name="sub_category_id" id="sub_category_id" class="form-select" >
                        <option value="" disabled {{ !isset($data) ? 'selected' : '' }}>{{ __('words.Select SubCategory Name') }}</option>
                        @foreach ($sub_categories as $sub_category)
                            <option value="{{ $sub_category->id }}" {{ isset($data) && $data->sub_category_id == $sub_category->id ? 'selected' : '' }}>
                                {{ $sub_category->name_en }}
                            </option>
                        @endforeach
                    </select> 
                </div>

                <!-- Image -->
                <div class="col-md-6">
                    <x-image-input accept="image/*" title="وێنەی پۆل" :value="isset($data) ? $data->image : null" />
                </div>  

                {{-- Submit Button --}}
                <div class="col-12 text-end">
                    <x-button :label="isset($data) ? 'نوێکردنەوە' : 'دروستکردن'" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
function previewImage(event, previewId) {
    const input = event.target;
    const preview = document.getElementById(previewId);
    preview.innerHTML = '';
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail';
            img.style.maxWidth = '100px';
            preview.appendChild(img);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function handleDrop(event, inputId) {
    event.preventDefault();
    document.getElementById('drop-area-' + inputId).classList.remove('border-primary');
    const files = event.dataTransfer.files;
    if (files.length > 0) {
        const input = document.getElementById(inputId);
        input.files = files;
        previewImage({ target: input }, inputId + '_preview');
    }
}
</script>
