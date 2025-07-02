@extends('layouts.casher')

@section('content')
<div class="container mt-4">
    <h2>Invoices Report</h2>
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
        </div>
        <div class="col-md-3">
            <select name="casher_id" class="form-control">
                <option value="">All Cashers</option>
                @foreach($cashers as $casher)
                    <option value="{{ $casher->id }}" {{ request('casher_id') == $casher->id ? 'selected' : '' }}>
                        {{ $casher->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
    </form>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Table Number</th>
                <th>Casher</th>

                <th>Total Price (IQD)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->table->table_number ?? '-' }}</td>
                <td>{{ $invoice->creator->name ?? $invoice->creator->email ?? '-' }}</td>
                <td>{{ number_format($invoice->total_price) }} IQD</td>
                <td>
                    @if($invoice->status == 1)
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-warning text-dark">Unpaid</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $invoices->links() }}
</div>
@endsection