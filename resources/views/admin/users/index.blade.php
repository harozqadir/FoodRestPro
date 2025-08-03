@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary fw-bold">Manage Users</h4>
        <a href="{{ route('admin.users.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-user-plus me-2"></i> Add New User
        </a>
    </div>

    <!-- Users Table -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="myTable" class="table table-hover table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Created By</th>
                            <th>Created At</th> 
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            {{-- <div class="d-flex justify-content-end mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div> --}}
        </div>
    </div>
</div>
{{--<script>
    let table = new DataTable('#myTable');
</script> --}}
  <!-- jQuery (required by DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <link href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
<script>
  
$(document).ready(function () {
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.users.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'username', name: 'username' },
            {
                data: 'role',
                name: 'role',
                render: function (data) {
                    const roles = { 1: 'Admin', 2: 'Server', 3: 'Chef', 4: 'Casher' };
                    return roles[data] || 'Unknown';
                }
            },
            { 
                data: 'creator_by', 
                name: 'creator_by',
                
             },
             { data: 'created_at', name: 'created_at' },
            { 
                data: 'actions', 
                name: 'actions', 
                searchable: false, 
                orderable: false,
                render: function(data, type, row) {
                    const id = row.id;
                   const editUrl = '{{ route("admin.users.edit", ":id") }}'.replace(':id', id);
const deleteUrl = '{{ route("admin.users.destroy", ":id") }}'.replace(':id', id);
                    return `
                        <div class="d-flex justify-content-center">
                            <a href="${editUrl}" class="btn btn-primary btn-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form id="delete-form-${id}" action="${deleteUrl}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteFunction(${id})" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    `;
                }
            }
        
        ]
    });
});

let  deleteFunction = (id) =>{
            Swal.fire({
                title: 'Are you sure to delete this?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Deleted!', 'Deleted Successfully', 'success');
                    setTimeout(() => {
                        document.getElementById('delete-form-' + id).submit();
                    }, 500);
                }
            });
        };
   
</script>

@endsection