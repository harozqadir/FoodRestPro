@extends('layouts.chef')

@section('content')
<div class="container my-5">
    <div class="row mb-4 text-center">
        <h2 class="fw-bold text-primary">{{ __('words.Chef Dashboard - Orders') }}</h2>
    </div>

    <!-- Filters -->
    <div class="row g-3 mb-3">
        <div class="col-md-3">
            <select id="statusFilter" class="form-select">
                <option value="">{{ __('words.All Statuses') }}</option>
                <option value="Pending">{{ __('words.Pending Orders') }}</option>
                <option value="Done">{{ __('words.Done Orders') }}</option>
                <option value="Arrived">{{ __('words.Arrived Orders') }}</option>
            </select>
        </div>
        
    </div>

    <!-- Advanced Table -->
    <div class="table-responsive  shadow rounded">
        <table id="myTable" class="table table-striped table-hover align-middle text-center mb-2 w-100" dir="rtl">
            <thead class="table-dark">
                <tr>
                    
                    <th>#</th>
                    <th>{{ __('words.Category & Foods') }}</th>
                    <th>{{ __('words.Quantity') }}</th>
                    <th>{{ __('words.Status') }}</th>
                    <th>{{ __('words.Created At') }}</th>
                    <th>{{ __('words.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($foodOrders as $index => $order)
                    <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start">
                                    <strong>{{ $order->food->sub_category->name_ckb ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">{{ $order->food->name_ckb ?? 'N/A' }}</small>
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
                                                $statusText = __('words.Pending Orders');
                                                break;
                                            case 2:
                                                $badgeClass = 'bg-success text-white';
                                                $statusText = __('words.Done Orders');
                                                break;
                                            case 3:
                                                $badgeClass = 'bg-primary text-white';
                                                $statusText = __('words.Arrived Orders');
                                                break;
                                            default:
                                                $badgeClass = 'bg-secondary';
                                                $statusText = 'Unknown';
                                        }
                                    @endphp
                                    <span class="badge fs-6 px-3 py-2 {{ $badgeClass }}">
                                       {{__( $statusText) }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if($order->status == 1)
                                        <form action="{{ route('chef.orders.updateStatus', ['id' => $order->id, 'status' => 2]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Mark as Done">{{ __('words.Mark as Done') }}</button>
                                        </form>
                                    @elseif($order->status == 2)
                                        <form action="{{ route('chef.orders.updateStatus', ['id' => $order->id, 'status' => 1]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-secondary" title="Mark as Not Yet">{{ __('words.Mark as Not Yet') }}</button>
                                        </form>
                                    @else
                                        <span class="text-muted">{{ __('words.No actions') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-4 text-muted">{{ __('words.No food orders at the moment.') }}</td></tr>
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
