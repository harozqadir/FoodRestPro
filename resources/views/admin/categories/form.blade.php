@extends('layouts.admin')

@section('content')

<div class="container">
<div class="container CustomBG shadow-sm rounded mt-3 py-3">

    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Categories </a>

<br><br>
<div class="mt-3">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Category Creation</h4>
            <br><br>
               <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);" style="text-decoration: none;">Dashboard</a></li>
                    <li class="breadcrumb-item active">Category Form</li>
                </ol>
               </div>
            
        </div>
        </div>

    </div>
</div>

{{-- index and upadte form Reusable form --}}

<form 
enctype="multipart/form-data"
action="{{ isset($data) ? route('admin.categories.update', ['category' => $data->id]) : route('admin.categories.store') }}" 
method="POST" 
class="row mt-4">
    @csrf
    @isset($data)
        @method('PUT')
    @endisset

    <div class="col-md-4 mt-3 position-relative">
        <label for="name_ckb" class="form-label">Name in Kurdish</label>
        <input type="text" class="form-control" name="name_ckb" value="{{ isset($data) ? $data->name_ckb : old('name_ckb') }}">
        @error('name_ckb')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
   <div class="col-md-4 mt-3 postion-relative">
    <label for="" class="form-label">Name in ar</label>
    <input type="text" class="form-control" value="{{isset($data) ? $data->name_ar : old('name_ar')}}" name="name_ar" >
    @error('name_ar')
    <div class="text-danger">{{ $message }}</div>
        
    @enderror
   </div>

   <div class="col-md-4 mt-3 postion-relative">
    <label for="" class="form-label">Name in en</label>
    <input type="text" class="form-control" value="{{isset($data) ? $data->name_en: old('name_en')}}" name="name_en" >
    @error('name_en')
    <div class="text-danger">{{ $message }}</div>
        
    @enderror
   </div>

   <div class="col-md-4 mt-3 postion-relative">
    <label for="" class="form-label">Image</label>
    <input type="file" class="form-control" name="image" >      
    @error('image')
    <div class="text-danger">{{ $message }}</div>
        
    @enderror
   </div>

<div class="col-12 mt-5">
    <button class="btn btn-success col-md-2 mt-4">
        @if(isset($data))
        <i class="fas fa-sync-alt"></i>update
        @else
        <i class="fas fa-plus"></i>create
        @endif
    </button>
</div>
</form>
</div>

@endsection