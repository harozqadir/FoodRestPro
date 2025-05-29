@extends('layouts.admin')


@section('content')

<div class="col-10 mx-auto">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                   <h4>{{$table ->name_en}}</h4>
                    <a  href="{{ route('admin.reservations.create',['table_id' => $table->id ])}}" class="btn btn-success">
                        <i class="fas fa-plus"></i>  Add
                    </a>
                    </div>
                
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0">
                        
                            <table id="myTable" class="table table-responsive table-bordered dt-reponsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width:100% vertical-align:middle">
                            <br>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone Number</th>
                                    <th>Hour</th>
                                    <th>Chair</th>
                                    <th>Added By </th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                               
                            
                            </tbody>
                        </table>
                    </div>
                    </div>
                        </div>

                    </div>
    {{-- {{$data->links('pagination::bootstrap-5')}} --}}
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    
    $(function(){
        let table = $('#myTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: //The ajax option in your DataTable is responsible for fetching data from the server.
          '{{ route("admin.reservations.show" , $table->id) }}',
          columns: [{
              data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              searchable: false,
              orderable: false
          },{
              data: 'name',
              name: 'name',
          },{
              data: 'phone-number',
              name: 'phone-number',
          },{
              data: 'hour',
              name: 'hour',
          } ,{
              data: 'chair',
              name: 'chair',
          },{
              data: 'user.email',
              name: 'user.email',
             
          },{
              data: 'created_at_readable',
              name: 'created_at_readable',
              searchable: false,
              orderable: false
          },{
              data: 'actions',
              name: 'actions',
              searchable: false,
              orderable: false,
              render: function(data, type, row){
                const id =row.id;
                const editurl = '{{ route('admin.reservations.edit', ['reservation' =>':id' , 'table_id'=> "$table->id"]) }}'
                const deleteurl = '{{ route('admin.reservations.destroy',['reservation' =>':id' , 'table_id'=> "$table->id"])  }}'
                
                return `
                  <a href='${editurl.replace(':id',id)}' class="btn btn-primary me-2">Edit</a>
                 <form id='${id}' action="${deleteurl.replace(':id',id)}" method="POST" style="display: inline-block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                   <button type="button" onclick="deleteFunction(${id})" class="btn btn-danger delete-btn" data-id="${row.id}" style="width: auto;"><i class="fas fa-trash"></i> DELETE</button>
                 </form>
                  `;
              }
            }
            ]
      }
        );
    
    });
            
</script>
@endsection