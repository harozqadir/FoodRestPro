@extends('layouts.casher')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Invoice for Table #{{ $table->table_number }}</h2>

    <div class="card">
        <div class="card-body">
            <h4>Table Details</h4>
            <p><strong>Table ID:</strong> {{ $table->id }}</p>
            <p><strong>Table Number:</strong> {{ $table->table_number }}</p>

            <h4 class="mt-4">Ordered Foods</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Food Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->orders as $order)
                    <tr>
                        <td>{{ $order->food->name }}</td>
                        <td>{{ $order->quantity }}</td>
                        <td>IQD {{ number_format($order->food->price, 3, '.', '') }}</td>
                        <td>IQD {{ number_format($order->food->price * $order->quantity, 3, '.', '') }}</td>
                        <td>
                            <!-- Example action: Remove item -->
                            <form action="{{ route('casher.tables.removeOrder', ['id' => $order->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Price</th>
                        <th colspan="2">IQD {{ number_format($invoice->total_price, 3, '.', '') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <a href="{{ route('casher.home') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
@endsection