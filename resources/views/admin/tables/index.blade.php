@extends('layouts.admin')

@section('content')

<div class="col-10 mx-auto">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0">
                        
                            <table id="myTable" class="table table-bordered dt-reponsive nowrap myTable"
                            style="border-collapse: collapse; border-spacing: 0; width:100% vertical-align:middle">
                            <br>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Table Number</th>
                                    <th>Set Reservation</th>
                                    <th>Created By</th>
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

        </div>
    </div>
</div>


<script>
    
    $(function(){
        let table = $('#myTable').DataTable({
            processing: true,
          serverSide: true,
          ajax: '{{ route("admin.tables.index") }}',
          columns: [{
              data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              searchable: false,
              orderable: false
          },{
              data: 'table_number',
              name: 'table_number',
          },
          {
              data: 'reservations',
              name: 'reservations',
              searchable: false,
              orderable: false,
              render: function(data, type, row){
                const id =row.id;
                const route = '{{ route('admin.reservations.show',':id') }}'
                
                return `
                  <a href='${route.replace(':id',id)}' class="btn btn-success d-block ">Set</a>
                  `;
              }
            },
           {
            data: 'user.username', // This is where you're getting the error
            name: 'user.username',
            render: function(data, type, row) {
                // Check if 'user' is null
                return data ? data : 'Admin';
            }
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
                const editurl = '{{ route('admin.tables.edit',':id') }}'
                const deleteurl = '{{ route('admin.tables.destroy',':id') }}'
                
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
      });
    });
    

</script>
@endsection