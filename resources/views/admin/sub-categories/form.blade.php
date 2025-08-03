@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary fw-bold">
            {{ isset($data) ? 'Update Sub-Category' : 'Create New Sub-Category' }}
        </h4>
        <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form 
                enctype="multipart/form-data"
                action="{{ isset($data) ? route('admin.sub-categories.update', ['sub_category' => $data->id]) : route('admin.sub-categories.store') }}"
                method="POST"
                class="row g-4">
                @csrf
                @isset($data)
                    @method('PUT')
                @endisset

                <!-- Name in Kurdish -->
                <div class="col-md-6">
                    <x-input title="Name in Kurdish" name="name_ckb" type="text" :dt="isset($data) ? $data : false" />
                </div>

                <!-- Name in Arabic -->
                <div class="col-md-6">
                    <x-input title="Name in Arabic" name="name_ar" type="text" :dt="isset($data) ? $data : false" />
                </div>

                <!-- Name in English -->
                <div class="col-md-6">
                    <x-input title="Name in English" name="name_en" type="text" :dt="isset($data) ? $data : false" />
                </div>

                <!-- Image Upload -->
                <div class="col-md-6">
                    <x-input title="Image" name="image" type="file" :dt="isset($data) ? $data : false" />
                </div>

                <!-- Parent Category Dropdown -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Parent Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(isset($data) ? ($category->id == $data->category_id) : old('category_id') == $category->id)>
                                {{ $category->name_en }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-end">
                    <x-button :chehckedifupdate=" isset($data) ? true : false " />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
