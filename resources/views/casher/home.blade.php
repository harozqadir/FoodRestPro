@extends('layouts.casher')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Casher Dashboard - Tables</h2>
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
        @foreach ($tables as $row)
        <div class="col">
            <a href="{{ route('casher.tables.invoice', ['id' => $row->id]) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 rounded-xl" 
                     style="background-color: {{ $row->invoice ? '#d4edda' : '#f8d7da' }};">
                    <div class="card-body text-center">
                        <img src="{{ asset('icons/chair.png') }}" alt="Table Icon" class="img-fluid mb-3" style="max-width: 50px;">
                        <h5 class="card-title">Table #{{ $row->table_number }}</h5>
                        @if ($row->invoice)
                            <span class="badge bg-success">Invoiced</span>
                            <p class="text-success mt-2">Total: IQD {{ number_format($row->invoice->total_price * 1500 / 1000, 0, '') }}</p>
                        @else
                            <span class="badge bg-danger">No Invoice</span>
                            <p class="text-danger mt-2">Pending</p>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection