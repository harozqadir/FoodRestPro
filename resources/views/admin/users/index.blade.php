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
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
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
{{--<script>
    let table = new DataTable('#myTable');
</script> --}}

<script>
    
  $(function(){
      let table = $('#myTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ route("admin.users.index") }}',
          columns: [{
              data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              searchable: false,
              orderable: false
          },{
              data: 'email',
              name: 'email',
          },{
              data: 'role_readable',
              name: 'role_readable',
              searchable: false,
              orderable: false
          },
          {
              data: 'user.email',
              name: 'user.email',
              defaultContent: ''
             
          },{
              data: 'created_at',
              name: 'created_at',
              searchable: false,
              orderable: false
          },{
              data: 'actions',
              name: 'actions',
              searchable: false,
              orderable: false,
          }]
      });
  });
</script>
@endsection