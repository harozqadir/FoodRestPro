@extends('layouts.admin')

@section('content')

<div class="container">
<div class="container CustomBG shadow-sm rounded mt-3 py-3">
<a  href="{{ route('admin.users.index') }}" class="btn btn-success"><i class="fas fa-arrrow-left">Back</i></a>

{{-- index and upadte form Reusable form --}}
<form 
    action="{{ isset($data) ? route('admin.users.update',['user' => $data->id]) : route('admin.users.store') }}" 
    method="post" class="row mt-4">
    @csrf
    @isset($data)
        @method('PUT')
    @endisset

   <div class="col-md-4 mt-3 postion-relative">
    <label for="" class="form-label">Email</label>
    <input type="email" class="form-control" value="{{isset($data) ? $data->email : old('email')}}" name="email" >
    @error('email')
    <div class="text-danger">{{ $message }}</div>
        
    @enderror
   </div>
   <div class="col-md-4 mt-3 postion-relative">
    <label for="" class="form-label">Password</label>
    <input type="password" class="form-control" value="" name="password" >
    @error('password')
    <div class="text-danger">{{ $message }}</div>
        
    @enderror

    </div>

    <div class="col-md-4 mt-3 postion-relative">
    <label for="" class="form-label">Password Confirmation</label>
    <input type="password" class="form-control" value="" name="password_confirmation" >
    </div>
   
    <div class="col-md-4 mt-3 postion-relative">
        <label for="" class="form-label">Role</label>
        <select name="role" id="" class="form-select">
          <option value=""></option>
          <option @selected (isset($data) ? $data->role == 1 : old('role') == 1 )  value="1">Admin</option>
          <option @selected (isset($data) ? $data->role == 2 : old('role') == 2 )  value="2">Server</option>
          <option @selected (isset($data) ? $data->role == 3 : old('role') == 3 )  value="3">Chief</option>
        </select>
        @error('role')
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