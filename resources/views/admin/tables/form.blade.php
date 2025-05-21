@extends('layouts.admin')

@section('content')

<div class=" mt-3">
 <div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0">Table Creation</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">Table Form</li>
                </ol>
            </div>
        </div>
    </div>
 </div>

</div>

{{-- index and upadte form Reusable form --}}
<div class="card mx-auto">

    <div class="card-body rounded mt-3 py-3">
        <a href="{{route('admin.tables.index')}}" class="btn btn-success"><i class="fas fa-arrow-left"></i>Back</a>
    
<form 
    action="{{ isset($data) ? route('admin.tables.update',['table' => $data->id]) : route('admin.tables.store') }}" 
    method="post" class="row mt-4">
    @csrf
    @isset($data)
        @method('PUT')
    @endisset

   <x-input title="Table Number" name="table_number"  :dt="isset($data) ? $data :false "  type="text"/>


<x-button :chehckedifupdate=" isset($data) ? true : false " />

   

</form>
</div>
</div>


@endsection