@extends('layouts.casher')

@section('content')
    <div class="container py-5">

        <!-- Invoice Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-2">
                    <span class="text-primary"><i class="fas fa-file-invoice-dollar me-2"></i>{{ __('words.Invoice ID') }}:
                    </span>
                    <span class="text-transparent">{{ $invoice->id }}</span>
                </h2>
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-auto">
                        <div class="d-flex flex-column align-items-start">
                            <span class="text-secondary fw-semibold">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $invoice->created_at->format('Y-m-d') }}
                            </span>
                            <span class="text-secondary fw-semibold">
                                <i class="fas fa-clock me-1"></i>
                                {{ $invoice->created_at->format('H:i:s') }}
                            </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="d-flex flex-column align-items-start">
                            <span class="text-secondary fw-semibold">
                                <i class="fas fa-chair me-1"></i>
                                {{ __('words.Table') }} {{ $invoice->table->table_number ?? 'N/A' }}
                            </span>
                            <span class="text-secondary fw-semibold">
                                <i class="fas fa-user me-1"></i>
                                {{ __('words.Server') }}: {{ $invoice->creator->username ?? __('words.Unknown') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex flex-column align-items-start">
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">{{ __('words.Unpaid') }}</span>

                    </div>
                </div>

            </div>

            <a href="{{ route('casher.home') }}" class="btn btn-outline-success d-flex align-items-center">
                <i class="fas fa-arrow-left"></i> {{ __('words.Back') }}
            </a>

        </div>

        <!-- Food Items Table - Modern Restaurant Style -->
        <div class="card shadow rounded mt-4">
            <div class="card-header bg-gradient bg-primary text-white">
                <h5 class="mb-0">{{ __('words.Ordered Foods') }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle text-center mb-0" id="orderedFoodTable"
                        dir="rtl">
                        <thead class="bg-gradient bg-primary text-white rudaw-font">
                            <tr>
                                <th class="rounded-start">#</th>
                                <th>{{ __('words.Food Name') }}</th>
                                <th>{{ __('words.Image') }}</th>
                                <th>{{ __('words.Price') }}</th>
                                <th>{{ __('words.Quantity') }}</th>
                                <th>{{ __('words.Subtotal') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoice->invoice_food as $index => $item)
                                <tr class="bg-white shadow-sm rounded-3 mb-2">
                                    <td class="fw-bold">{{ $index + 1 }}</td>
                                    <td class="text-start">
                                        <span
                                            class="fw-semibold rudaw-font">{{ optional($item->food)->name_ckb ?? '-' }}</span>
                                        <div class="small text-muted">{{ optional($item->food)->description ?? '' }}</div>
                                    </td>
                                    <td>
                                        <img src="{{ asset('foods-image/' . ($item->food->image ?? 'default.png')) }}"
                                            alt="{{ optional($item->food)->name_ckb }}"
                                            class="rounded-circle border border-2 shadow-sm"
                                            style="width:48px; height:48px; object-fit:cover;">
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark fs-6 px-3 py-2 shadow-sm">
                                            {{ number_format($item->price, 0, '.', ',') }} {{ __('words.IQD') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary fs-6 px-3 py-2">{{ $item->quantity }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info text-dark fs-6 px-3 py-2 shadow-sm">
                                            {{ number_format($item->quantity * $item->price, 0, '.', ',') }}
                                            {{ __('words.IQD') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light fw-bold">
                                <td></td>
                                <td colspan="2" class="text-end border-0">
                                    <span class="text-secondary">{{ __('words.Total Quantity') }}</span>
                                </td>
                                <td></td>
                                <td class="border-0">
                                    <span
                                        class="badge bg-primary fs-5 px-4 py-2 shadow-sm">{{ $invoice->invoice_food->sum('quantity') }}</span>
                                </td>
                                <td class="text-align-end border-0">
                                    <span class="badge bg-success fs-5 px-4 py-2 shadow-lg">
                                        <i class="fas fa-money-bill-wave me-2"></i>
                                        {{ number_format($invoice->invoice_food->sum(function ($row) {return $row->quantity * $row->price;}),0,'.',',') }}
                                        <span class="ms-2">{{ __('words.IQD') }}</span>
                                    </span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if ($invoice->status == 2 && $invoice->paid_by)
                    <div class="mt-4 text-end text-muted small">
                        <i class="fas fa-user-check text-success"></i>
                        {{ __('words.Paid by') }}:
                        <strong>{{ $invoice->paidBy->username ?? __('words.Unknown') }}</strong>
                    </div>
                @endif

                @if ($invoice->status == 1)
                    <form action="{{ route('invoice.pay', $invoice->id) }}" method="POST" class="mt-5">
                        @csrf
                        <button type="submit"
                            class="btn btn-success btn-lg w-100 shadow rounded-pill d-flex justify-content-center align-items-center gap-3 py-3 fs-5">
                            <i class="fas fa-cash-register"></i>
                            <span class="fw-bold">{{ __('words.Pay Now') }}</span>
                        </button>
                    </form>
                @endif
            </div>

        </div>

        <style>
            .table th,
            .table td {
                vertical-align: middle !important;
            }

            .rounded-circle {
                background: #fff8e1;
                box-shadow: 0 2px 8px #ffb34733;
                transition: transform .2s;
            }

            .rounded-circle:hover {
                transform: scale(1.08);
                box-shadow: 0 0 0 4px #ffb34755;
            }

            @media (max-width: 576px) {
                .rounded-circle {
                    width: 32px !important;
                    height: 32px !important;
                }
            }
        </style>
    @endsection
  
   