@extends('layouts.casher')

@section('content')
<div class="container mt-4">
    
    <div class="card">
        <div class="card-header">
            <h3>Invoice for Table #{{ $table->table_number }}</h3>
            @if($table->invoice)
                <p class="text-muted">
                    Date: {{ $table->invoice->created_at->format('Y-m-d') }} |
                    Time: {{ $table->invoice->created_at->format('H:i:s') }}
                </p>
            @else
                <p class="text-muted">No invoice found for this table.</p>
            @endif
            <div style="position: absolute; top: 10px; right: 10px;">
                <a href="{{ route('casher.home') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        </div>
        <div class="card-body">
            @if($table->invoice)
                <table class="table table-hover table-bordered" style="border-collapse: collapse; background-color: #ffffff; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <thead style="background-color: #007bff; color: #ffffff;">
                        <tr>
                            <th style="padding: 10px; text-align: center; font-size: 1.1rem;">Food Item</th>
                            <th style="padding: 10px; text-align: center; font-size: 1.1rem;">Quantity</th>
                            <th style="padding: 10px; text-align: center; font-size: 1.1rem;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($table->invoice->invoice_food as $item)
                            <tr style="transition: background-color 0.3s;">
                                <td style="padding: 10px; text-align: center; font-size: 1rem; color: #333;">{{ $item->food->name_en }}</td>
                                <td style="padding: 10px; text-align: center; font-size: 1rem; color: #333;">{{ $item->quantity }}</td>
                                <td style="padding: 10px; text-align: center; font-size: 1rem; color: #007bff;">{{ number_format($item->price) }} IQD</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" style="padding: 10px; text-align: left; font-size: 1.2rem; font-weight: bold; color: #333;">Total Price: {{ number_format($finalTotalPrice) }} IQD</td>
                            <td style="padding: 10px; text-align: center;">
                                <form action="{{ route('casher.process.payment', ['id' => $table->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-success btn-lg shadow-sm" 
                                            style="font-size: 1rem; padding: 10px 20px; width: 100%; border-radius: 10px;">
                                        <i class="fas fa-money-bill-wave me-2"></i>
                                        Pay
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                
            @else
                <p>No invoice found for this table.</p>
            @endif
        </div>
    </div>
    <div class="container">
    
        @yield('content')
    </div>
</div>
@endsection