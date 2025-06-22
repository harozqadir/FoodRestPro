@extends('layouts.server')

@section('content')
<div class="mt-5">
    <div class="d-flex justify-content-between ">
         <div class="d-flex align-items-center">
        <h3>
            Table Number: #{{$table->table_number}}
        </h3>
        @if($invoice)
         <span>  - Invoice ID: #{{$invoice->id}}  - </span> 
         
         <form id="{{ $invoice->id }}" action="{{route('server.invoice.delete',['id'=>$invoice->id])}}" method="POST">   
         @csrf
        <button type="button" onclick="deleteFunction({{$invoice->id}})" class="text-danger btn" style="border-block-color: transparent; border-radius: 0px; border: 1px solid transparent;">
            Delete This Invoice.
        </button>
    </form>
         @endif
        </div>
   
        
        <a href="{{route('server.home')}}" class="btn btn-primary" 
        style="margin-right: 15px;">Back </a>
    
</div>
<br>
         {{-- Show Ordered Foods Here   --}}

     @if ($invoice)
    <div >
        <h4>Ordered Food</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Food</th>
                    <th>Quantity</th>
                    <th>Price</th>
                
                    <th>Action</th>
                </tr>
            </thead>
        <tbody>
        @if($invoice)
        @foreach ($invoice->invoice_food as $row)
        <tr>
            <td>{{$row->food->sub_category->name_en}} {{$row->food->name_en}}</td>
            <td>{{$row->quantity}}</td>
           
            <td>IQD {{ number_format($row->quantity * $row->price, 1, '') }}</td>           
            <td class="d-flex">  
            <form action="{{route('server.foods.plus_or_minus', ['id' => $row->id,'value'=> 1])}}" method="POST" style="display: inline-block; margin-right: 5px;">
                @csrf
                <button class="btn btn-success"><i class="fas fa-plus"></i></button>
            </form>  
            <form action="{{route('server.foods.plus_or_minus',['id' => $row->id,'value'=> -1])}}" method="POST" style="display: inline-block;">
                @csrf
                <button class="btn btn-danger"><i class="fas fa-minus"></i></button>
            </form>  
        </td>
        </tr>
        @endforeach
        @endif
      </tbody>
        </table>
      </div>
        @endif
    </div>

    {{-- Order Foods Here start --}}
     <div class="m-4">
    <h4 class="mt-3">Categories</h4>
    <div class="row">
        @foreach ($categories as $category)
              <div class="col-3 p-2">
                 <div onclick="show_sub_categories({{$category->id}})" class="card">
                    <div class="card-body text-center">
                      <img src="{{ asset('categories-image/'.$category->image) }}" class="col-12" alt="" style="width: 100%; height: 150px; object-fit: cover;">
                      <h5 class="mt-5">{{$category->name_en}}</h5>
                    </div>
                  </div>
              </div>
        @endforeach

    </div>
</div>

     {{-- Subcategories and Foods --}}
     <div class="m-4">
        <form action="{{ route('server.foods.store', ['id' => $table->id]) }}" method="POST" >
            @csrf
            <input type="hidden" name="table_id" value="{{$table->id}}">

             <div class="row mt-5">
              @foreach ($sub_categories as $sub_category)
                <div class="category{{$sub_category->category_id}} foods d-none"  style="margin-bottom: 70px">

                  <div class="d-flex align-items-center" >
                   
                   <img src="{{ asset('sub-categories-image/'.$sub_category->image) }}" class="col-1" alt="" >
                    <h5 class="ms-2">{{$sub_category->name_en}}</h5>
             
                </div>
              <div class="mt-4 row">
                   @foreach ($sub_category->foods as $row)
                    <div class="p-1 col-3 text-center">
                        <div class="card">
                            <div class="card-body inputsBox">
                               <p>{{$row->name_en}}</p>
                               <p>{{$row->price_readable}}</p>
                               <input type="hidden" value="{{$row->id}}" name="food_id[]" >
                               <input type="hidden" value="{{$row->price}}" name="price[]" >
                               <div class="d-flex justify-content-between ">
                                <button onclick="increment({{$row->id}})" type="button" class="btn btn-success">
                                    <i class="fas fa-plus"></i>
                                </button>
                                  <div class="col-3 ">
                                 <input readonly id="{{$row->id}}" class="form-control text-center" type="text" name="quantity[]"  value="0">
                                  </div>
                            
                                 <button onclick="decrement({{$row->id}})" type="button" class="btn btn-danger">
                                     <i class="fas fa-minus"></i>
                                 </button>
     
                               </div>

                            </div>
                        </div>

                      </div>
                    @endforeach
               </div>
             
            </div>
              @endforeach
        </div>
        <input type="number" readonly value="0" id="total"  name="total" class="form-control">
        <button type="submit" class="btn col-12 btn-success mt-5">Order</button>
    </form>
</div>
    
</div>
<script>
    // Function to show sub-categories when a category is clicked
    let show_sub_categories= (id) =>{
             let foods = document.getElementsByClassName('foods');

             // Hide all foods first
                if(foods.length>0){
                for(let i=0; i<foods.length; i++){
                    foods[i].classList.add('d-none');
                     }
                 }
        
             // Show the sub-categories of the clicked category

             let sub_categories = document.getElementsByClassName('category'+id);

                 if(sub_categories.length>0){
                  for(let i=0; i<sub_categories.length; i++){
                    sub_categories[i].classList.toggle('d-none');
                    }
                 }
           }
        
        let increment = (id) => {
            // Get the input element by its ID and increment its value
            let input = document.getElementById(id);
             input.value++;

             // Call the calculation function to update the total
            calculation();
        }

            

        let decrement = (id) => {

            let input = document.getElementById(id);
            // Check if the value is greater than 0 before decrementing
            if(input.value > 0)
             input.value--;
            calculation();

        }

        let calculation = () => {
    let inputs = document.getElementsByClassName('inputsBox'); // Get all input boxes
    let total = 0;

    // Loop through each input box to calculate the total
    for (let i = 0; i < inputs.length; i++) {
        let price = parseFloat(inputs[i].querySelector('input[name="price[]"]').value); // Get the price
        let quantity = parseInt(inputs[i].querySelector('input[name="quantity[]"]').value); // Get the quantity

        // Ensure price and quantity are valid numbers before adding to total
        if (!isNaN(price) && !isNaN(quantity)) {
            total += price * quantity;
        }
    }

    // Update the total price field
    document.getElementById('total').value = total;
};

</script>
@endsection