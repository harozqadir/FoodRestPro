@extends('layouts.casher')

@section('content')


<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body position-relative">
            <a href="{{ route('casher.home') }}" class="btn btn-sm btn-outline-primary position-absolute top-0 end-0 m-3">
                <i class="fas fa-arrow-left"></i> Back
            </a>

            <h3 class="mb-1">Invoice #{{ $invoice->id }}</h3>
            <p class="text-muted mb-2">Date: {{ $invoice->created_at->format('Y-m-d') }} | Time: {{ $invoice->created_at->format('H:i:s') }}</p>

            <div class="mb-4">
                <span class="badge bg-info me-2">Table: #{{ $invoice->table->table_number ?? 'N/A' }}</span>
                <span class="badge bg-secondary">Created By: {{ $invoice->creator->username ?? 'Unknown' }}</span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Food</th>
                            <th>Price (IQD)</th>
                            <th>Quantity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($invoice->invoice_food as $item)
                            <tr>
                                <td>{{ $item->food->sub_category->name_en ?? '-' }}</td>
                                <td>{{ number_format($item->price) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>
                                    @if($invoice->status == 1)
                                        <span class="badge bg-warning text-dark">Unpaid</span>
                                    @elseif($invoice->status == 2)
                                        <span class="badge bg-success">Paid</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total --}}
            <div class="d-flex justify-content-between align-items-center mt-4 px-2 py-3 bg-light rounded-3 shadow-sm">
                <h5 class="mb-0 fw-semibold">Total Price</h5>
                <h4 class="text-primary mb-0 fw-bold">
                    <i class="fas fa-money-bill-wave"></i> IQD {{ number_format($invoice->total_price, 0, '.', ',') }}
                </h4>
            </div>

            {{-- Paid by info --}}
            @if($invoice->status == 2 && $invoice->paid_by)
                <div class="mt-3 text-end text-muted small">
                    <i class="fas fa-user-check text-success"></i>
                    Paid by: <strong>{{ $invoice->paidBy->username ?? 'Unknown' }}</strong>
                </div>
            @endif

            {{-- Pay button --}}
            @if ($invoice->status == 1)
                <form action="{{ route('invoice.pay', $invoice->id) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg w-100 shadow rounded-pill d-flex justify-content-center align-items-center gap-2 py-3">
                        <i class="fas fa-cash-register fs-5"></i>
                        <span class="fs-5 fw-bold">Pay Now</span>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
