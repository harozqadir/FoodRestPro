@extends('layouts.server')

@section('content')
<div>
        <div class="d-flex justify-content-between ">
            
              <h3> Table Number: #{{$table->table_number}}</h3>
              <a href="{{route('server.home')}}" class="btn btn-primary" 
              style="margin-right: 15px;">Back 
             </a>
        </div>

        <hr>





{{-- Order Foods Here start --}}

         {{-- Categories --}}
               <div class="m-4">
                   <div class="row">
                       @foreach ($categories as $category)
                           <div class="col-3 p-2">
                               <div onclick="show_sub_categories({{ $category->id }})" class="card category-card" style="cursor: pointer; border: 2px solid #007bff; border-radius: 10px; transition: transform 0.2s, box-shadow 0.2s;">
                                   <div class="card-body text-center">
                                       <h5 class="mt-3 category-title" style="font-weight: bold; color: #007bff; position: relative;">{{ $category->name_en }}</h5>
                                   </div>
                               </div>
                          </div>
                       @endforeach
                   </div>  
                </div>
                
      {{-- Sub_Categories --}}
      <div>
      <form action="{{route('server.foods.store')}}" method="POST">
          @csrf
         <input type="hidden" name="table_id" value="{{$table->id}}">
           <div class="row mt-5">
           @foreach ($sub_categories as $sub_category)
            <div class="category{{ $sub_category->category_id }} foods d-none" style="margin-bottom: 70px">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('sub-categories-image/' . $sub_category->image) }}" class="col-1" alt="">
                    <h5 class="ms-2">{{ $sub_category->name_en }}</h5>
                </div>

            {{-- Foods --}}
                <div class="mt-4 row">
                    @foreach ($sub_category->foods as $index => $row)
                        <div class="p-1 col-3 text-center">
                            <div class="card">
                                <div class="card-body inputsBox">
                                    <p>{{ $row->name_en }}</p>
                                    <p>{{ $row->price_readable }}</p>
                                    <input type="hidden" value="{{ $row->id }}" name="food_id[]">
                                    <input type="hidden" value="{{ $row->price }}" name="price[]">
                                    <div class="d-flex justify-content-between">
                                        <button onclick="increment({{ $row->id }})" type="button" class="btn btn-success">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <div class="col-3">
                                            <input readonly id="{{ $row->id }}" class="form-control text-center" type="text" name="quantity[]" value="0">
                                        </div>
                                        <button onclick="decrement({{ $row->id }})" type="button" class="btn btn-danger">
                                            <i class="fas fa-minus"></i> </button> </div>
                                      </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                </div>
              @endforeach
             </div>
            <input type="number" readonly value="0" id="total" name="total" class="form-control">
            <button type="submit" class="btn col-12 btn-success mt-5" onclick="hideOpenCategory()">Order</button>
        </form>
        
      </div>
  

</div>
<script>
    
                $(document).ready(function() {
              $('#myTable').DataTable();
          });

    // Function to show sub-categories when a category is clicked
        let show_sub_categories = (id) => {
        
          let foods = document.getElementsByClassName('foods');

          if(foods.length >0){
           for (let i = 0; i < foods.length; i++) {
            foods[i].classList.add('d-none'); // Hide all foods
             }
          }    

         let sub_categories = document.getElementsByClassName('category' + id); // Get sub-categories by category ID
         if(sub_categories.length > 0){
           for (let i = 0; i < sub_categories.length; i++) 
           {
            sub_categories[i].classList.toggle('d-none'); // Show the selected category's foods
             }
           }
    
        };
    
    
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
        if (input.value > 0) {
         input.value-- ;
        }

        calculation();
    }

    let calculation = () => {
        let inputs = document.getElementsByClassName('inputsBox'); // Get all input boxes
        
        let total = 0;

        // Loop through each input box to calculate the total
        for (let i = 0; i < inputs.length; i++) {
           total+= inputs[i].children[3].value * inputs[i].children[4].children[1].children[0].value;
        
        }
        // Update the total price field
        document.getElementById('total').value = total;
        };

          // Function to hide the currently open category when the "Order" button is clicked
          let hideOpenCategory = () => {
          let openCategories = document.querySelectorAll('.foods:not(.d-none)');
            openCategories.forEach(category => {
              category.classList.add('d-none'); // Hide the currently open category
              });
              };
</script>


@endsection


{{-- Show Ordered Foods Here  

<div >
    <h4>Ordered Food</h4>
    @if($invoice && $invoice->invoice_food->count())

    <div class="table-responsive">

    <table class="table table-striped" id="myTable">
        <thead>
            <tr>
                <th>Food Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Price Foods</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
    <tbody>
     
        @foreach ($invoice->invoice_food as $row)
        <tr>
            <td>{{ $row->food->name_en }}</td>
            <td>IQD {{ number_format($row->price, 1, '') }}</td>
            <td>{{ $row->quantity }}</td>
            <td>IQD {{ number_format($row->quantity * $row->price, 1, '') }}</td>
            <td>{{ $invoice->creator ? $invoice->creator->name : 'Unknown' }}</td>
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
    
  </tbody>
    </table>
   @else
   <p>No ordered foods for this table.</p>
    @endif
  </div>
</div> --}}