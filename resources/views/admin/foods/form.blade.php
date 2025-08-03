@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="container CustomBG shadow-sm rounded mt-3 py-3">
         <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary fw-bold">Manage Foods</h4>
        </a>
                    <a href="{{ route('admin.foods.index') }}" class="btn btn-success"><i class="fas fa-list"></i> Food List</a>

    </div>
   {{-- Food List Button  Back Button --}}
        <div class="d-flex align-items-center justify-content-between mb-2">
        
        </div>
        <div class="mt-3">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Food Creation</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);" style="text-decoration: none;">Dashboard</a></li>
                                <li class="breadcrumb-item active">Food Form</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Food Creation Form --}}
        <form enctype="multipart/form-data" 
              action="{{ isset($data) ? route('admin.foods.update', ['food' => $data->id]) : route('admin.foods.store') }}" 
              method="POST" 
              class="row mt-4">
            @csrf
            @isset($data)
                @method('PUT')
            @endisset

            {{-- Name in Kurdish --}}
            <div class="col-12 mb-3">
                <label for="name_ckb" class="form-label">Name in Kurdish</label>
                <input type="text" name="name_ckb" id="name_ckb" class="form-control" value="{{ old('name_ckb', isset($data) ? $data->name_ckb : '') }}" placeholder="Enter the name in Kurdish" required>
            </div>

            {{-- Name in Arabic --}}
            <div class="col-12 mb-3">
                <label for="name_ar" class="form-label">Name in Arabic</label>
                <input type="text" name="name_ar" id="name_ar" class="form-control" value="{{ old('name_ar', isset($data) ? $data->name_ar : '') }}" placeholder="Enter the name in Arabic" required>
            </div>

            {{-- Name in English --}}
            <div class="col-12 mb-3">
                <label for="name_en" class="form-label">Name in English</label>
                <input type="text" name="name_en" id="name_en" class="form-control" value="{{ old('name_en', isset($data) ? $data->name_en : '') }}" placeholder="Enter the name in English" required>
            </div>

            {{-- Price --}}
            <div class="col-12 mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', isset($data) ? $data->price : '') }}" placeholder="Enter the price" required>
            </div>

            {{-- Sub-category Dropdown --}}
            <div class="col-12 mb-3">
                <label for="sub_category_id" class="form-label">Select Sub-category</label>
                <select name="sub_category_id" id="sub_category_id" class="form-control" required>
                    <option value="" disabled selected>Select a Sub-category</option>
                    @foreach ($sub_categories as $sub_category)
                        <option value="{{ $sub_category->id }}" {{ isset($data) && $data->sub_category_id == $sub_category->id ? 'selected' : '' }}>
                            {{ $sub_category->name_en }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Submit Button --}}
            <div class="col-12 text-end">
                <x-button :chehckedifupdate=" isset($data) ? true : false " />
            </div>
        </form>

        

    </div>
</div>

@endsection
