@extends('layouts.server')

@section('content')
<div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3" style="margin-left: 10px;">
    @foreach ($tables as $row )
    
    <a href="{{route ('server.foods',['id' => $row->id])}}" class="p-2 col-3" style="text-decoration: none; color: inherit;">
       <div class="card rounded-xl ">
        <div class="card-body text-center">
            <img src="{{asset('icons/chair.png')}}" alt="" 
            class="col-10 mx-auto">
            
            <p class="text-center mt-4 h4"> {{$row->table_number}}</p>
            
        </div>
    </div>
</a>
    
        
    @endforeach
   

</div>
@endsection
