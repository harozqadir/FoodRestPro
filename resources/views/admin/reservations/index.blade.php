@extends('layouts.admin')

@section('content')


    <div class="container py-4">
    <!-- Modern Page Header -->
    <x-restaurant-header
    :title="__('words.Manage Reservations')"
    :subtitle="__('words.Restaurant Reservations & Management')"
    :icon="'fas fa-calendar-check'"
    :action-route="route('admin.reservations.create')"
    :action-text="__('words.Add New Reservation')"
    :action-icon="'fas fa-user-plus me-2 fs-4'"
/>

 <!-- Reusable Modern Card Component -->
    <x-modern-card>
        <!-- Enhanced Search Bar -->
        <div class="row mb-4 justify-content-start" dir="rtl">
            <div class="col-12 col-md-6">
                <div class="input-group shadow-sm rounded-pill bg-white border border-0">
                    <span class="input-group-text bg-gradient text-primary border-0 rounded-start-pill px-4" style="background: linear-gradient(90deg, #4e54c8 0%, #8f94fb 100%);">
                        <i class="fas fa-search fs-5"></i>
                    </span>
                    <input 
                        type="text" 
                        id="customSearch" 
                        class="form-control border-0 shadow-none bg-transparent px-3 py-2 rounded-end-pill" 
                        placeholder="{{ __('words.Search Username or Role') }}"
                        style="font-size: 1.1rem;"
                    >
                </div>
            </div>
        </div>

    <!-- Responsive Table -->
        <div class="table-responsive">
            <table id="myTable" class="table modern-table table-hover align-middle text-center mb-2 w-100" dir="rtl">
                <thead>
                    <tr>
                            <th>#</th>
                            <th>{{ __('words.Guest Name') }}</th>
                            <th>{{ __('words.Guest Phone') }}</th>
                            <th>{{ __('words.Guest Hour') }}</th>
                            <th>{{ __('words.Guest Chair') }}</th>
                            <th>{{ __('words.Guest Table Number') }}</th>
                            <th>{{ __('words.Added By') }}</th>
                            <th>{{ __('words.Created At') }}</th>
                            <th>{{ __('words.Actions') }}</th>
                         </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </x-modern-card>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">

<script>
$(document).ready(function () {
    var table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        searching: false,
        lengthChange: false,
        pageLength: 25,
        ajax: { 
                url: "{{ route('admin.reservations.index') }}",
              data: function (d) {
                d.custom_search = $('#customSearch').val();
            }
        },language: {
            info: "{{ __('words.Showing') }} _START_ {{ __('words.to') }} _END_ {{ __('words.of') }} _TOTAL_ {{ __('words.entries') }}",
            infoEmpty: "{{ __('words.No entries to show') }}",
            paginate: {
                first: '{{ __("words.First") }}',
                last: '{{ __("words.Last") }}',
                next: '{{ __("words.Next") }}',
                previous: '{{ __("words.Previous") }}'
            }
        },
        buttons: ['colvis'],
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
                                <i class="fas fa-edit"></i> {{ __('words.Edit') }}
                            </a>
                    <form id="delete-form-${id}" action="${deleteUrl}" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteFunction(${id})" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                        <i class="fas fa-trash"></i> {{ __('words.Delete') }}
                    </button>
                </form>
                        </div>
                    `;
                }
            }
        ]
});
$('#customSearch').on('keyup change', function() {
        table.draw();
    });
            });


        
       
  
let deleteFunction = (id) => {
    Swal.fire({
        title: '{{ __('words.Are you sure to delete this?') }}',
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
