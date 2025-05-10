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
                                    <th>Name Kuridsh</th>
                                    <th>Name Arabic</th>
                                    <th>Name English</th>
                                    <th>Image</th>
                                    <th>Cetegory</th>
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
{{-- <script>
    let table = new DataTable('#myTable');
</script> --}}
<script>
    
    
      let table = $('#myTable').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ route("admin.sub-categories.index") }}',
          columns: [{
              data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              searchable: false,
              orderable: false
          },{
              data: 'name_ckb',
              name: 'name_ckb',
          },{
              data: 'name_ar',
              name: 'name_ar',
          },{
              data: 'name_en',
              name: 'name_en',
          },
          {
              data: 'full_path_image',
              name: 'full_path_image',
              render: function(data, type, row){
                return `<img src="${data}" style="width: 50px; height: 50px;">`
              }
          },{
              data: 'category.name_en',
              name: 'category.name_en',
             
          },
          {
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
                const editurl = '{{ route('admin.sub-categories.edit',':id') }}'
                const deleteurl = '{{ route('admin.categories.destroy',':id') }}'
                
                return `
                  <a href='${editurl.replace(':id',id)}' class="btn btn-primary me-2">Edit</a>
                 <form id='${id}' action="${deleteurl.replace(':id',id)}" method="POST" style="display: inline-block;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                   <button type="button" onclick="deleteFunction(${id})" class="btn btn-danger delete-btn" data-id="${row.id}" style="width: auto;"><i class="fas fa-trash"></i> DELETE</button>
                 </form>
                  `;
              }
          },
        ]
      
  })
</script>
@endsection