@extends('layouts.admin')


@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-10">
        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                <h4 class="mb-2 mb-md-0">{{ $sub_category->name_en }}</h4>
                <a href="{{ route('admin.foods.create', ['sub_category' => request('sub_category')]) }}" class="btn btn-success">
                    <i class="fas fa-plus"></i> Add
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-bordered table-striped align-middle w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name Kurdish</th>
                                <th>Name Arabic</th>
                                <th>Name English</th>
                                <th>Price</th>
                                <th>Added By</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Table rows --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 
<div class="col-10" style="margin-left: 60px;">
    <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                               <h4>{{$sub_category ->name_en}}</h4>
                                 <a  href="{{ route('admin.foods.create',['sub_category' => request('sub_category')])}}" class="btn btn-success">
                                 <i class="fas fa-plus"></i>  Add
                                </a>
                            </div>
                        </div>
                        <div class="card-body" >
                           <div class="table-responsive mb-0">
                            <table id="myTable" class="table table-responsive " 
                                  style="border-collapse: collapse; border-spacing: 0; width:100%; vertical-align:middle">
                                  <br>
                                <thead>
                                   <tr>
                                    <th>#</th>
                                    <th>Name Kurdish</th>
                                    <th>Name Arabic</th>
                                    <th>Name English</th>
                                    <th>Price</th>
                                    <th>Added By </th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                   </tr>
                                </thead>
                            </table>
                          </div>
                        </div>
                     </div>
                </div>

    </div>

</div> --}}






{{-- <script>
    let table = new DataTable('#myTable');
</script> --}}
<script>
    
    
      let table = $('#myTable').DataTable({
        
          processing: true,
          serverSide: true,
          ajax: '{{ route('admin.foods.index') }}?sub_category={{ request('sub_category') }}',
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
                data: 'price_readable',
                name: 'price_readable'
            },
          {
              data: 'user.username',
              name: 'user.username',
             
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
                const editurl = '{{ route('admin.foods.edit',':id') }}?sub_category={{ request('sub_category') }}'
                const deleteurl = '{{ route('admin.foods.destroy',':id') }}?sub_category={{ request('sub_category')}}'
                
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
            
            
      
  )
</script>
@endsection