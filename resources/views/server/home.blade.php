@extends('layouts.server')

@section('content')
    <h2 class="text-center mb-4">Server Dashboard - Tables</h2>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($tables as $table)
            <div class="col">
                <a href="{{ route('server.foods', ['id' => $table->id]) }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 rounded-xl"
                         style="background-color: {{ $table->status === 'ordered' ? '#ffcc00' : '#f8d7da' }};">
                        <div class="card-body text-center">
                            <img src="{{ asset('icons/chair.png') }}" alt="Table Icon" class="img-fluid mb-3" style="max-width: 50px;">
                            <h5 class="card-title">Table #{{ $table->table_number }}</h5>
                            @if ($table->status === 'ordered')
                                <span class="badge bg-danger text-light fs-5 px-3 py-2">Ordered</span>
                            @else
                                <span class="badge bg-success text-white fs-5 px-3 py-2">Available</span>
                            @endif
                        </div>
                    </div>
                </a>
                {{-- <div class="text-center mt-2">
                    <a href="{{ route('server.invoice', ['table_id' => $table->id]) }}" class="btn btn-primary btn-sm">View Invoice</a>
                </div> --}}
            </div>
        @endforeach
    </div>
@endsection
