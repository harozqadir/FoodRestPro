@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 text-primary fw-bold">
        {{ isset($data) ? 'Update Table' : 'Create New Table' }}
    </h4>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm px-4 rounded-pill">
        <i class="fas fa-list"></i>
        <span class="fw-semibold">Reservation List</span>
    </a>
</div>

    <!-- Form Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form 
                action="{{ isset($data) ? route('admin.tables.update',['table' => $data->id]) : route('admin.tables.store') }}" 
                method="POST" class="row g-4">
                @csrf
                @isset($data)
                    @method('PUT')
                @endisset

                <!-- Table Number -->
                <div class="col-md-6">
                    <x-input title="Table Number" name="table_number" type="text" :dt="isset($data) ? $data : false" />
                </div>

                @if ($errors->any())
                    <div class="col-12">
                        <div class="alert alert-danger mt-2">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="col-12 text-end">
                    <x-button :chehckedifupdate=" isset($data) ? true : false " />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
