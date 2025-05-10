@extends('layouts.admin')

@section('content')

<div class=" mt-3">
 <div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Category Creation</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Category Form</li>
                </ol>
            </div>
        </div>
    </div>
 </div>

</div>

{{-- index and upadte form Reusable form --}}
<div class="card mx-auto">

    <div class="card-body rounded mt-3 py-3">
        <a href="{{route('admin.sub-categories.index')}}" class="btn btn-success"><i class="fas fa-arrow-left"></i>Back</a>
    </div>

<form 
enctype="multipart/form-data"
action="{{ isset($data) ? route('admin.sub-categories.update', ['sub_category' => $data->id]) : route('admin.sub-categories.store') }}"
method="POST" 
class="row mt-4">
    @csrf
    @isset($data)
        @method('PUT')
    @endisset


    <x-input title="Name in kurdish" name="name_ckb" type="text"  :dt="isset($data) ? $data : false " />
    <x-input title="Name in Arabic" name="name_ar" type="text"  :dt="isset($data) ? $data : false" />
    <x-input title="Name in English" name="name_en" type="text"  :dt="isset($data) ? $data : false" />
    <x-input title="Image" name="image" type="file"  :dt="isset($data) ? $data : false " />
    
    <div class="col-md-4 mt-3 position-relative">
        <label for="">Category</label>
        <select name="category_id" id="category_id" class="form-select">
          <option value=""></option>
            @foreach($categories as $category)
                <option @selected(isset($data) ? ($category-> id == $data-> category_id ? true : false) : (old('category_id') == $category->id ? true : false)) value="{{ $category->id }}" >
                    {{ $category->name_en }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="text-danger mt-1">{{ $message }}</div>
            
        @enderror
    </div>
    <x-button :chehckedifupdate=" isset($data) ? true : false " />

</form>
</div>
</div>
@endsection