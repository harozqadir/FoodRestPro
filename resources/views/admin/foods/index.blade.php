{{-- filepath: resources/views/admin/foods/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <!-- Advanced Page Header -->
    <x-restaurant-header
        :title="__('words.Manage Foods')"
        :subtitle="__('words.Restaurant Foods & Management')"
        :icon="'fas fa-utensils'"
        :action-route="route('admin.foods.create')"
        :action-text="__('words.Create New Food')"
        :action-icon="'fas fa-plus me-2 fs-4'"
    />

   <x-modern-card>
    <!-- Advanced Filters -->
    <form id="filtersForm" class="row g-3 mb-4 align-items-end">
        <!-- Subcategory Filter -->
        <div class="col-md-4">
            <div class="form-floating">
                <select id="sub_category_id" name="sub_category_id" class="form-select" aria-label="{{ __('words.SubCategory Name') }}">
                    <option value="">{{ __('words.All Subcategories') }}</option>
                    @foreach ($sub_categories as $sub_category)
                        <option value="{{ $sub_category->id }}">{{ $sub_category->name_en }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <!-- Status Filter -->
        <div class="col-md-4">
            <div class="form-floating">
                <select id="is_active" name="is_active" class="form-select" aria-label="{{ __('words.Status') }}">
                    <option value="">{{ __('words.All Statuses') }}</option>
                    <option value="1">{{ __('words.Active') }}</option>
                    <option value="0">{{ __('words.Inactive') }}</option>
                </select>
            </div>
        </div>
        <!-- Global Search -->
        <div class="col-md-4">
            <div class="form-floating">
                <input 
                    type="text" 
                    id="global_search" 
                    name="global_search" 
                    class="form-control" 
                    placeholder="{{ __('words.Search Foods') }}" 
                    aria-label="{{ __('words.Search Foods') }}"
                >
                <label for="global_search">{{ __('words.Search Foods') }}</label>
            </div>
        </div>
    </form>

    <!-- Advanced Table -->
    <div class="table-responsive  shadow rounded">
        <table id="myTable" class="table table-striped table-hover align-middle text-center mb-2 w-100" dir="rtl">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>{{ __('words.Name Kurdish') }}</th>
                    <th>{{ __('words.Name Arabic') }}</th>
                    <th>{{ __('words.Name English') }}</th>
                    <th>{{ __('words.Price') }}</th>
                    <th>{{ __('words.Image') }}</th>
                    <th>{{ __('words.SubCategory Name') }}</th>
                    <th>{{ __('words.Created By') }}</th>
                    <th>{{ __('words.Status') }}</th>
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

<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script> --}}
<script>
$(function () {
    const table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        searching: false,
        lengthChange: false,
        pageLength: 8,
        ajax: {
            url: "{{ route('admin.foods.index') }}",
            data: function (d) {
                d.sub_category_id = $('#sub_category_id').val();
                d.is_active = $('#is_active').val();
               
                d.global_search = $('#global_search').val();
            }
        },
        language: {
            info: "{{ __('words.Showing') }} _START_ {{ __('words.to') }} _END_ {{ __('words.of') }} _TOTAL_ {{ __('words.entries') }}",
            infoEmpty: "{{ __('words.No entries to show') }}",
            paginate: {
                first: '{{ __("words.First") }}',
                last: '{{ __("words.Last") }}',
                next: '{{ __("words.Next") }}',
                previous: '{{ __("words.Previous") }}'
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
            { data: 'name_ckb', name: 'name_ckb' },
            { data: 'name_ar', name: 'name_ar' },
            { data: 'name_en', name: 'name_en' },
            {
                data: 'full_path_image',
                name: 'full_path_image',
                searchable: false,
                orderable: false,
                render: function(data) {
                    // Render image with timestamp to avoid caching issues
        return data ? `<img src="/${data}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #dee2e6;">` : 'No Image';
                }
            },
            { data: 'price', name: 'price' },
            {
                data: 'sub_category.name_en',
                name: 'sub_category.name_en',
                render: data => data ? data : '-'
            },
            {
                data: 'user.username',
                name: 'user.username',
                searchable: false,
                orderable: false,
                render: data => data ? data : 'Admin'
            },
            {
                data: 'is_active',
                name: 'is_active',
                render: data => data ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'
            },
            {
                data: 'created_at',
                name: 'created_at',
                searchable: false,
                orderable: false,
                render: data => moment(data).format('YYYY-MM-DD HH:mm:ss')
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
                        <div class="d-flex justify-content-center gap-2">
                            <a href="${editUrl}" class="btn btn-primary btn-sm modern-btn" data-bs-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i> {{ __('words.Edit') }}
                            </a>
                            <form id="delete-form-${id}" action="${deleteUrl}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm modern-btn" onclick="deleteFunction(${id})" data-bs-toggle="tooltip" title="Delete">
                                    <i class="fas fa-trash"></i> {{ __('words.Delete') }}
                                </button>
                            </form>
                        </div>
                    `;
                }
            }
        ],
        drawCallback: function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    // Advanced filter triggers
    $('#filtersForm input, #filtersForm select').on('change keyup', function () {
        table.ajax.reload();
    });
});

function deleteFunction(id) {
    Swal.fire({
        title: '{{ __('words.Are you sure to delete this?') }}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire('Deleted!', '{{ __("words.Food deleted successfully") }}', 'success');
            setTimeout(() => {
                document.getElementById('delete-form-' + id).submit();
            }, 500);
        }
    });
}
</script>
{{-- @endpush --}}
@endsection
