@extends('layouts.admin')

@section('content')

<div class="container">
<div class="container CustomBG shadow-sm rounded mt-3 py-3">

    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Categories </a>


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


    <x-input title="Name in kurdish" name="name_ckb" type="text"  :dt="isset($data) ? $data : false " />
    <x-input title="Name in Arabic" name="name_ar" type="text"  :dt="isset($data) ? $data : false" />
    <x-input title="Name in English" name="name_en" type="text"  :dt="isset($data) ? $data : false" />
    <x-input title="Image" name="image" type="file"  :dt="isset($data) ? $data : false " />

    <x-button :chehckedifupdate=" isset($data) ? true : false " />

</form>
</div>

@endsection