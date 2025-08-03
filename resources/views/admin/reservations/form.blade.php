@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <h2 class="mb-0">{{ isset($data) ? 'Edit Reservation' : 'Create Reservation' }}</h2>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-primary">
                  <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
            <div class="mb-2 text-muted">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Table Reservation Form</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body p-4">
            <form 
                enctype="multipart/form-data"
                action="{{ isset($data) ? route('admin.reservations.update', $data->id) : route('admin.reservations.store') }}"
                method="POST"
                autocomplete="off">
                @csrf
                @isset($data)
                    @method('PUT')
                @endisset
                   
                <!-- Hidden User ID Field -->
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <div class="row gx-3 gy-2">
                    <div class="col-md-6">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $data->name ?? '') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $data->phone_number ?? '') }}" class="form-control @error('phone_number') is-invalid @enderror" required>
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Hour <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            id="hourInput"
                            name="hour" 
                            value="{{ old('hour', $data->hour ?? '') }}" 
                            class="form-control @error('hour') is-invalid @enderror" 
                            required 
                            oninput="formatAndValidateHour()"
                            maxlength="5" 
                            placeholder="HH:MM"
                        >
                        <div class="form-text text-muted" id="hourPreview" style="font-size: 14px;"></div>
                        @error('hour')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Chair <span class="text-danger">*</span></label>
                        <input type="number" min="1" name="chair" value="{{ old('chair', $data->chair ?? '') }}" class="form-control @error('chair') is-invalid @enderror" required>
                        @error('chair')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Table Number <span class="text-danger">*</span></label>
                        <select name="table_id" class="form-select @error('table_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('table_id', $data->table_id ?? '') ? '' : 'selected' }}>Select a table</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}"
                                    {{ old('table_id', $data->table_id ?? '') == $table->id ? 'selected' : '' }}>
                                    Table No. {{ $table->table_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('table_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success shadow">
                        <i class="fas fa-save me-1"></i>
                        {{ isset($data) ? 'Update' : 'Create' }} Reservation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Format and validate hour input (HH:MM)
function formatAndValidateHour() {
    let input = document.getElementById('hourInput');
    let value = input.value;

    // Check if input matches HH:MM format
    let regex = /^([0-1]?[0-9]|2[0-3]):([0-5][0-9])$/;
    if (!regex.test(value)) {
        document.getElementById('hourPreview').innerText = 'Invalid time format (HH:MM)';
    } else {
        document.getElementById('hourPreview').innerText = '';
    }
}
</script>
@endsection
