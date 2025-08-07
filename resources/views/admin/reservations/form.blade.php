{{-- filepath: resources/views/admin/reservations/form.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Modern Page Header -->
    <x-restaurant-header
    :title="__('words.Manage Reservations')"
    :subtitle="__('words.Restaurant Reservations & Management')"
    :icon="'fas fa-calendar-check'"
    :action-route="route('admin.reservations.index')"
    :action-text="__('words.Back')"
    :action-icon="'fas fa-arrow-left me-2 fs-4'"
/>
   

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form 
                enctype="multipart/form-data"
                action="{{ isset($data) ? route('admin.reservations.update', $data->id) : route('admin.reservations.store') }}"
                method="POST"
                autocomplete="off"
                class="row g-4"
            >
                @csrf
                @isset($data)
                    @method('PUT')
                @endisset

                <!-- Hidden User ID Field -->
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <div class="col-md-6">
                    <x-input 
                        title="{{ __('words.Guest Name') }}" 
                        name="name" 
                        :dt="isset($data) ? $data : false" 
                        type="text" 
                    />
                </div>

                <div class="col-md-6">
                    <x-input 
                        title="{{ __('words.Guest Phone') }}" 
                        name="phone_number" 
                        :dt="isset($data) ? $data : false" 
                        type="text" 
                    />
                </div>

                <div class="col-md-4">
                    <x-input 
                        title="{{ __('words.Guest Chair') }}" 
                        name="chair" 
                        :dt="isset($data) ? $data : false" 
                        type="number" 
                    />
                </div>

                <div class="col-md-4">
                    <x-input 
                        title="{{ __('words.Guest Hour') }}" 
                        name="hour" 
                        :dt="isset($data) ? $data : false" 
                        type="text" 
                    />
                </div>

                <div class="col-md-4">
                    <label for="table_id" class="form-label fw-semibold">
                        {{ __('words.Guest Table Number') }} <span class="text-danger">*</span>
                    </label>
                    <select 
                        id="table_id"
                        name="table_id" 
                        class="form-select rounded-3 shadow-sm @error('table_id') is-invalid @enderror" 
                        required
                    >
                        <option value="" disabled {{ old('table_id', $data->table_id ?? '') ? '' : 'selected' }}>
                            <span class="text-muted">{{ __('words.Select a table') }}</span>
                        </option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}"
                                {{ old('table_id', $data->table_id ?? '') == $table->id ? 'selected' : '' }}>
                                {{ __('Table No:') }} {{ $table->table_number }}
                            </option>
                        @endforeach
                    </select>
                    @error('table_id')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="col-12 text-end mt-4">
                    <x-button :label="isset($data) ? 'نوێکردنەوە' : 'دروستکردن'" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection