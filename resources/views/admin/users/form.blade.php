@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Modern Page Header -->
    <x-restaurant-header
    :title="__('words.Manage Users')"
    :subtitle="__('words.Restaurant Staff & Permissions')"
    :icon="'fas fa-users'"
    :action-route="route('admin.users.index')"
    :action-text="__('words.Back')"
    :action-icon="'fas  fa-arrow-left me-2 fs-4'"
/>


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
                    <label for="username">{{ __('words.Username') }}</label>
                    <x-input title="" name="username" :dt="isset($data) ? $data : false" type="text" />
                </div>

                <!-- Password -->
                <div class="col-md-6">
                    <label for="password">{{ __('words.Password') }}</label>
                    <x-input title="" name="password" :dt="false" type="password" />
                </div>

                <!-- Password Confirmation -->
                <div class="col-md-6">
                    <label for="password_confirmation">{{ __('words.Password Confirmation') }}</label>
                    <x-input title="" name="password_confirmation" :dt="false" type="password" />
                </div>

                <!-- Role -->
                <div class="col-md-6">
                    <label for="role">{{ __('words.Role') }}</label>
                    <x-role-select :role="isset($data) ? $data->role : old('role')" />
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
