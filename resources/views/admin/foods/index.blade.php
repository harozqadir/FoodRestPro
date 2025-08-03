{{-- filepath: resources/views/admin/foods/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary fw-bold">Manage Foods</h4>
        <a href="{{ route('admin.foods.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus me-2"></i> Add New Food
        </a>
    </div>

    <!-- Filters Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="form-floating">
                <select id="sub_category_id" class="form-select" aria-label="Subcategory Filter">
                    <option value="">Select Subcategory</option>
                    @foreach ($sub_categories as $sub_category)
                        <option value="{{ $sub_category->id }}">{{ $sub_category->name_en }}</option>
                    @endforeach
                </select>
                {{-- <label for="sub_category_id">Subcategory</label> --}}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-floating">
                <select id="is_active" class="form-select"  aria-label="Status Filter">
                    <option value="">Select Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                {{-- <label for="is_active">Status</label> --}}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-floating">
                <input type="number" id="price_min" class="form-control" placeholder="Min Price" aria-label="Min Price Filter">
                <label for="price_min">Min Price</label>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-floating">
                <input type="number" id="price_max" class="form-control" placeholder="Max Price" aria-label="Max Price Filter">
                <label for="price_max">Max Price</label>
            </div>
        </div>
    </div>
     
    <!-- Foods Table -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
        
                <table id="myTable" class="table table-hover table-bordered align-middle text-center w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name English</th>
                            <th>Price</th>
                            <th>Subcategory</th>
                            <th>Created By</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables will populate this -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
{{-- <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

<script>
$(document).ready(function () {
    var table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.foods.index") }}',
            data: function (d) {
                d.sub_category_id = $('#sub_category_id').val();
                d.is_active = $('#is_active').val();
                d.price_min = $('#price_min').val();
                d.price_max = $('#price_max').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
            { data: 'name_en', name: 'name_en' },
            { data: 'price', name: 'price' },
            {
                data: 'sub_category.name_en',
                name: 'sub_category.name_en',
                render: function(data) {
                    return data ? data : '-';
                }
            },
            {
                data: 'user.username',
                name: 'user.username',
                searchable: false,
    orderable: false,
                render: function(data) {
                    return data ? data : 'Admin';
                }
            },
            {
                data: 'is_active',
                name: 'is_active',
                render: function(data) {
                    return data ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                }
            },
            {
                data: 'created_at',
                name: 'created_at',
                searchable: false,
                orderable: false,
                render: function(data) {
                    return moment(data).format('YYYY-MM-DD HH:mm:ss');
                }
            },
            {
                data: 'actions',
                name: 'actions',
                searchable: false,
                orderable: false,
                render: function(data, type, row) {
                    const id = row.id;
                    const editUrl = '{{ route("admin.foods.edit", ":id") }}'.replace(':id', id);
                    const deleteUrl = '{{ route("admin.foods.destroy", ":id") }}'.replace(':id', id);
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

    // Apply filters when any of them change
    $('#sub_category_id, #is_active, #price_min, #price_max').on('change', function () {
        table.ajax.reload();
    });

     // Global search
    $('#global_search').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Initialize Tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
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