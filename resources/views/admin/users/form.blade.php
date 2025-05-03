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
<div>
   <x-input title="Email" name="email"  :dt="isset($data) ? $data :false "  type="email"/>
   <x-input title="Password" name="password"  :dt="false"   type="password"/>
   <x-input title="Password Confirmation" name="password_confirmation"  :dt="false" type="password"/>
   <x-role-select :role="isset($dt) ? $dt->role : old('role')" />


   </div>
<x-button :chehckedifupdate=" isset($data) ? true : false " />

</form>
</div>

@endsection