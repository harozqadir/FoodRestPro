@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h4 class="text-primary fw-bold">Manage Reservations</h>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('admin.reservations.create') }}" class="btn btn-success shadow-sm">
                <i class="fas fa-plus me-1"></i> Add Reservation
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-hover align-middle mb-0 w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Hour</th>
                            <th>Chair</th>
                            <th>Table Number</th>
                            <th>Added By</th>
                            <th>Created At</th>
                            <th >Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- DataTable AJAX fills this --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">

<script>
$(document).ready(function(){
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.reservations.index")}}',
        columns: [
            { data: 'DT_RowIndex',
             name: 'DT_RowIndex',
              orderable: false, 
              searchable: false, 
              className: 'text-center' },
            { data: 'name', name: 'name' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'hour', name: 'hour' },
            { data: 'chair', name: 'chair' },
            {
              data: 'table_number', // Use the newly added 'table_number' column
                name: 'table_number',
                render: function(data) {
                    return data ? data : 'N/A'; // Ensure the table number is rendered correctly
                }
            },
               { 
                data: 'user.username', // Show the username of the user who created the reservation
                name: 'user.username',
                render: function(data) {
                    return data ? data : 'Admin'; // If no username, show 'N/A'
                }
            },
            { data: 'created_at_readable', name: 'created_at_readable', orderable: false, searchable: false },
           { 
                data: 'actions', 
                name: 'actions', 
                searchable: false, 
                orderable: false,
                render: function(data, type, row) {
                    const id = row.id;
                    const editUrl = '{{ route("admin.reservations.edit", ":id") }}'.replace(':id', id);
                    const deleteUrl = '{{ route("admin.reservations.destroy", ":id") }}'.replace(':id', id);

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

            // Submit the delete form
            document.getElementById(`delete-form-${id}`).submit();

            // Reload the table (after deletion)
            $('#myTable').DataTable().ajax.reload();
            }, 500);
        }
    });
}
</script>


@endsection
