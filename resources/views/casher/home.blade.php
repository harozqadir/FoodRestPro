@extends('layouts.casher')

@section('content')
    <h2 class="text-center mb-4">Casher Dashboard - Tables</h2>
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
        @foreach ($tables as $table)
            <a href="{{ route('casher.tables.invoice', ['id' => $table->id]) }}" 
               class="text-decoration-none">
                <div class="container mt-4 hover-effect" 
                     style="cursor: pointer; transition: transform 0.2s;">
                    <div class="card shadow-sm border-0 rounded-xl" 
                         style="background-color: {{ $table->status === 'pending_payment' ? '#fff3cd' : ($table->status === 'ordered' ? '#d4edda' : '#f8d7da') }};">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">
                                Table #{{ $table->table_number }}
                            </h5>
                            <p>Status: 
                                @if ($table->status === 'pending_payment')
                                    <span class="badge bg-warning text-dark">Pending Payment</span>
                                @elseif ($table->status === 'ordered')
                                    <span class="badge bg-success">Ordered</span>
                                @else
                                    <span class="badge bg-danger">Available</span>
                                @endif
                            </p>
                            <p>Total: {{ number_format($table->total_price) }} IQD</p>  </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <style>
        .hover-effect:hover {
            transform: scale(1.02);
        }
    </style>
@endsection