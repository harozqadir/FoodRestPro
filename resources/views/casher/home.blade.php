@extends('layouts.casher')

@section('content')

<h2 class="text-center mb-4">{{ __('words.Casher Dashboard - Tables') }}</h2>
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($tables as $table)
            <div class="col">
                @if ($table->invoice)
                    <a href="{{ route('casher.invoice.show', ['id' => $table->invoice->id]) }}" class="text-decoration-none">
                    </a>
                @else
                    <a href="#" class="text-decoration-none disabled" tabindex="-1" aria-disabled="true">
                    </a>
                @endif
                    <div class="card shadow-sm border-0 rounded-xl"
                         style="background-color: {{ $table->status === 'ordered' ? '#ffcc00' : '#f8d7da' }};">
<div class="card-body text-center rudaw-font">
                        <img src="{{ asset('icons/chair.png') }}" alt="Table Icon" class="img-fluid mb-3" style="max-width: 50px;">
                    <h5 class="card-title">{{ __('words.Table Number') }}: {{ $table->table_number }}</h5>
                    @php
                      $latestInvoice = $table->invoices->first();
                    @endphp
                    @if ($latestInvoice && $latestInvoice->status == 1)
            <a href="{{ route('casher.invoice.show', ['id' => $latestInvoice->id]) }}" class="text-decoration-none">
               <span class="badge bg-danger text-light fs-5 px-3 py-2">{{ __('words.Unpaid') }}</span>
                @else
            <a href="#" class="text-decoration-none disabled" tabindex="-1" aria-disabled="true">
             <span class="badge bg-success text-white fs-5 px-3 py-2">{{ __('words.Available') }}</span>

        @endif

                </div>
            </div>
        </a>
    </div>
@endforeach
    </div>
</div>
</div>
@endsection

    
