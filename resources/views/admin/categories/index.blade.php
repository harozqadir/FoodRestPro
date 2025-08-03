@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary fw-bold">Manage Categories</h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus me-2"></i> Add New Category
        </a>
    </div>

    <!-- Categories Table -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="myTable" class="table table-hover table-bordered align-middle text-center w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name Kurdish</th>
                            <th>Name Arabic</th>
                            <th>Name English</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables handles this -->
                    </tbody>
                </table>
            </div>

            {{-- Pagination (if needed) --}}
            {{-- {{$data->links('pagination::bootstrap-5')}} --}}
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">

<script>
$(document).ready(function () {
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.categories.index") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
            { data: 'name_ckb', name: 'name_ckb' },
            { data: 'name_ar', name: 'name_ar' },
            { data: 'name_en', name: 'name_en' },
            {
                data: 'full_path_image',
                name: 'full_path_image',
                render: function(data) {
        return data ? `<img src="/${data}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #dee2e6;">` : 'No Image';
}
            },
            { data: 'created_at_readable', name: 'created_at_readable', searchable: false, orderable: false },
            {
                data: 'user.username',
                name: 'user.username',
                render: function(data) {
                    return data ? data : 'Admin';
                }
            },
            { 
                data: 'actions', 
                name: 'actions', 
                searchable: false, 
                orderable: false,
                render: function(data, type, row) {
                    const id = row.id;
                  const editUrl = '{{ route("admin.categories.edit", ":id") }}'.replace(':id', id);
const deleteUrl = '{{ route("admin.categories.destroy", ":id") }}'.replace(':id', id);
                    return `
                        <div class="d-flex justify-content-center">
                            <a href="${editUrl}" class="btn btn-primary btn-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                           <form id="delete-form-${id}" action="${deleteUrl}" method="POST" style="display: inline-block;">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="DELETE">
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

function deleteFunction(id) {
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
}
</script>
@endsection
