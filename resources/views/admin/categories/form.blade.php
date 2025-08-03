@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary fw-bold">
            {{ isset($data) ? 'Update Category' : 'Create New Category' }}
        </h4>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

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
                    <x-input title="Name Kurdish" name="name_ckb" type="text" :dt="isset($data) ? $data : false" />
                </div>

                <!-- Name Arabic -->
                <div class="col-md-6">
                    <x-input title="Name Arabic" name="name_ar" type="text" :dt="isset($data) ? $data : false" />
                </div>

                <!-- Name English -->
                <div class="col-md-6">
                    <x-input title="Name English" name="name_en" type="text" :dt="isset($data) ? $data : false" />
                </div>

                <!-- Image -->
                <div class="col-md-6">
                    <x-input title="Image" name="image" type="file" :dt="isset($data) ? $data : false" />
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
