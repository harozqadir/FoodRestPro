@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Modern Page Header -->
    <x-restaurant-header
        :title="__('words.Manage Categories')"
        :subtitle="__('words.Restaurant Categories & Management')"
        :icon="'fas fa-folder'"
        :action-route="route('admin.categories.index')"
        :action-text="__('words.Back')"
        :action-icon="'fas fa-arrow-left me-2 fs-4'"
    />

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form 
                enctype="multipart/form-data"
                action="{{ isset($data) ? route('admin.categories.update', ['category' => $data->id]) : route('admin.categories.store') }}" 
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

                <!-- Image Input -->
                <div class="col-md-6">
                    <x-image-input accept="image/*" title="وێنەی پۆل" :value="isset($data) ? $data->image : null" />
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-end">
                    <x-button :label="isset($data) ? 'نوێکردنەوە' : 'دروستکردن'" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
@endpush
