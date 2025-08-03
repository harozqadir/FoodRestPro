@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary fw-bold">
            {{ isset($data) ? 'Update User' : 'Create New User' }}
        </h4>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form 
                action="{{ isset($data) ? route('admin.users.update', $data->id) : route('admin.users.store') }}" 
                method="POST" class="row g-4">
                @csrf
                @isset($data)
                    @method('PUT')
                @endisset

                <!-- Username -->
                <div class="col-md-6">
                    <x-input title="Username" name="username" :dt="isset($data) ? $data : false" type="text" />
                </div>

                <!-- Password -->
                <div class="col-md-6">
                    <x-input title="Password" name="password" :dt="false" type="password" />
                </div>

                <!-- Password Confirmation -->
                <div class="col-md-6">
                    <x-input title="Password Confirmation" name="password_confirmation" :dt="false" type="password" />
                </div>

                <!-- Role -->
                <div class="col-md-6">
                    <x-role-select :role="isset($data) ? $data->role : old('role')" />
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
