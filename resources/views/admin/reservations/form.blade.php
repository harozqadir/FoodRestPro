@extends('layouts.admin')

@section('content')

<div class="container">
<div class="container CustomBG shadow-sm rounded mt-3 py-3">
<br><br>
<div class="mt-3">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Food Creation</h4>
            <br><br>
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

{{-- index and upadte form Reusable form --}}
<div class="card-body rounded mt-3 py-3">
    <a href="{{route('admin.reservations.show', request('table_id'))}}" class="btn btn-success" >
        <i class="fas fa-arrow-left"> Back</i>
    </a>
</div>

<form 
enctype="multipart/form-data"
action="{{ isset($data) ? route('admin.reservations.update', ['reservation' => $data->id]) : route('admin.reservations.store') }}" 
method="POST" 
class="row mt-4">
    @csrf
    @isset($data)
        @method('PUT')
    @endisset


    <x-input title="Name" name="name" type="text"  :dt="isset($data) ? $data : false " />
    <x-input title="Phone Number" name="phone-number" type="text"  :dt="isset($data) ? $data : false" />
    <x-input title="hour" name="hour" type="text"  :dt="isset($data) ? $data : false" />
    <x-input title="chair" name="chair" type="text"  :dt="isset($data) ? $data : false" />

    <input type="hidden" name="table_id" value="{{ request('table_id') }}">
    <x-button :chehckedifupdate=" isset($data) ? true : false " />

</form>
</div>

@endsection