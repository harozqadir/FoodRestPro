@extends('layouts.chef')

@section('content')
<div class="container my-5">
    <div class="row mb-4 text-center">
        <h2 class="fw-bold text-primary">Kitchen Order Dashboard</h2>
    </div>

    <!-- Filters -->
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <select id="statusFilter" class="form-select">
                <option value="">All Statuses</option>
                <option value="Pending">Pending</option>
                <option value="Done">Done</option>
                <option value="Arrived">Arrived</option>
            </select>
        </div>
        
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="ordersTable" class="table table-hover table-bordered align-middle text-center w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Category & Food</th>
                            <th>Quantity</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($foodOrders as $index => $order)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start">
                                    <strong>{{ $order->food->sub_category->name_en ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $order->food->name_en ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark px-3 py-2 fs-6">
                                        {{ $order->quantity }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        switch($order->status) {
                                            case 1:
                                                $badgeClass = 'bg-warning text-dark';
                                                $statusText = 'Pending';
                                                break;
                                            case 2:
                                                $badgeClass = 'bg-success text-white';
                                                $statusText = 'Done';
                                                break;
                                            case 3:
                                                $badgeClass = 'bg-primary text-white';
                                                $statusText = 'Arrived';
                                                break;
                                            default:
                                                $badgeClass = 'bg-secondary';
                                                $statusText = 'Unknown';
                                        }
                                    @endphp
                                    <span class="badge fs-6 px-3 py-2 {{ $badgeClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if($order->status == 1)
                                        <form action="{{ route('chef.orders.updateStatus', ['id' => $order->id, 'status' => 2]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Mark as Done">✔ Mark as Done</button>
                                        </form>
                                    @elseif($order->status == 2)
                                        <form action="{{ route('chef.orders.updateStatus', ['id' => $order->id, 'status' => 1]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Mark as Not Yet">↺ Mark as Not Yet</button>
                                        </form>
                                    @else
                                        <span class="text-muted">No actions</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">No food orders at the moment.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function () {
        let table = $('#ordersTable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [],
            dom: 'lrtip',
        });

        // Filter by status
        $('#statusFilter').on('change', function () {
            table.column(3).search(this.value).draw();
        });

       
    });
</script>
@endsection
