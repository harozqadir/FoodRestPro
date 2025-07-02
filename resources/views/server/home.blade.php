@extends('layouts.server')

@section('content')

    <h2 class="text-center mb-4">Server Dashboard - Tables</h2>
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-4">
        @foreach ($tables as $table)
            <div class="col">
                <a href="{{ route('server.foods', ['id' => $table->id]) }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 rounded-xl" 
                         style="background-color: {{ $table->status === 'ordered' ? '#d4edda' : '#f8d7da' }};">
                        <div class="card-body text-center">
                            <img src="{{ asset('icons/chair.png') }}" alt="Table Icon" class="img-fluid mb-3" style="max-width: 50px;">
                            <h5 class="card-title">Table #{{ $table->table_number }}</h5>
                            @if ($table->status === 'ordered')
                                <span class="badge bg-success">Ordered</span>
                                <p class="text-success mt-2">Foods Ordered</p>
                            @else
                                <span class="badge bg-danger">Pending</span>
                                <p class="text-danger mt-2">No Orders</p>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection