@extends('layouts.chief')

@section('content')
<div class="row m-5">
    <div>
        <h4>Ordered Food</h4>
        <table class="table table-striped">
            <tr>
            <th>Food</th>
            <th>Quantity</th>
            <th>Action</th>
        </tr>
      
        @foreach ($invoice_foods as $row)
        <tr>
            <td>{{$row->food->sub_category->name_en}} {{$row->food->name_en}}</td>
            <td>{{$row->quantity}}</td>
            <td class="d-flex">  
            <form action="{{route('chief.update-state', ['id' => $row->id, 'state' => ($row->status == 1 ? 2 : 1)])}}" method="POST" style="display: inline-block; margin-right: 5px;">
                @csrf
                <button class="btn {{$row->status == 1 ? 'btn-success' : 'btn-primary'}}">
                    {{$row->status == 1 ? 'Done' : 'Change To Not Yet'}}
                </button>
            </form>  
             
        </td>

        </tr>
            
        @endforeach
       
        </table>
        
    </div>
   

</div>
@endsection
