@extends('layouts.casher')

@section('content')
    <div class="container py-5">

        <!-- Header & Filters -->
        <div class="mb-4">
            <!-- Title -->
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary mb-1">
                    <i class="bi bi-graph-up"></i> {{ __('words.Cashier Report Dashboard') }}
                </h2>
            </div>
            <!-- Filters Form -->
            <form method="GET"
                class="row gy-2 gx-3 align-items-center bg-white p-4 rounded-4 shadow-sm border justify-content-center">
                @foreach ([['id' => 'start_date', 'label' => __('words.Start Date'), 'icon' => 'calendar-date', 'type' => 'date', 'value' => request('start_date')], ['id' => 'end_date', 'label' => __('words.End Date'), 'icon' => 'calendar-date', 'type' => 'date', 'value' => request('end_date')]] as $field)
                    <div class="col-md-3 col-12">
                        <label for="{{ $field['id'] }}" class="form-label fw-semibold mb-1">
                            <i class="bi bi-{{ $field['icon'] }}"></i> {{ $field['label'] }}
                        </label>
                        <input type="{{ $field['type'] }}" id="{{ $field['id'] }}" name="{{ $field['id'] }}"
                            class="form-control border-primary" value="{{ $field['value'] }}"
                            style="direction: rtl; text-align: right;" lang="ckb" placeholder="{{ $field['label'] }}">
                    </div>
                @endforeach
                <!-- Cashier Select -->
                <div class="col-md-3 col-12">
                    <label for="cashier_id" class="form-label fw-semibold mb-1">
                        <i class="bi bi-person-badge"></i> {{ __('words.Cashier') }}
                    </label>
                    <select name="cashier_id" id="cashier_id" class="form-select border-primary">
                        <option value=""></option>
                        @foreach ($cashiers as $cashier)
                            <option value="{{ $cashier->id }}"
                                {{ request('cashier_id') == $cashier->id ? 'selected' : '' }}>
                                {{ $cashier->username }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Actions -->
                <div class="col-md-3 col-12 d-flex flex-column flex-md-row gap-2 align-items-stretch mt-md-4 mt-3">
                    <button type="submit"
                        class="btn btn-primary rounded-3 flex-fill py-2 shadow-sm d-flex align-items-center justify-content-center">
                        <i class="bi bi-funnel-fill me-2"></i> <span>{{ __('words.Apply Filters') }}</span>
                    </button>
                    <button type="reset" onclick="window.location='{{ route('casher.reports') }}'"
                        class="btn btn-light border-danger text-danger rounded-3 flex-fill py-2 shadow-sm d-flex align-items-center justify-content-center">
                        <i class="bi bi-x-circle me-2"></i> <span>{{ __('words.Clear Filters') }}</span>
                    </button>
                </div>
            </form>

            <!-- Info Cards -->
            <div class="mt-4">
                <div class="row g-4 justify-content-center">
                    @foreach ([
            [
                'icon' => 'cash-coin',
                'color' => 'primary',
                'value' => number_format($totalSales),
                'label' => __('words.Total Sales'),
                'badge' => __('words.Sales'),
                'unit' => __('words.IQD'),
            ],
            [
                'icon' => 'receipt',
                'color' => 'info',
                'value' => $totalInvoices,
                'label' => __('words.Total Invoices'),
                'badge' => __('words.Invoices'),
            ],
            [
                'icon' => 'exclamation-circle',
                'color' => 'danger',
                'value' => $unpaidInvoices,
                'label' => __('words.Unpaid'),
                'badge' => __('words.Unpaid'),
            ],
        ] as $card)
                        <div class="col-md-4 col-sm-6">
                            <div class="card border-0 shadow-lg rounded-4 bg-white position-relative overflow-hidden h-100">
                                <div class="card-body text-center py-4">
                                    <div class="bg-{{ $card['color'] }} bg-opacity-10 rounded-circle p-3 mb-3">
                                        <i class="bi bi-{{ $card['icon'] }} fs-1 text-{{ $card['color'] }}"></i>
                                    </div>
                                    <div class="fw-bold fs-3 text-{{ $card['color'] }}">
                                        {{ $card['value'] }}
                                        @isset($card['unit'])
                                            <span class="ms-1 fs-6 text-muted">{{ $card['unit'] }}</span>
                                        @endisset
                                    </div>
                                    <div class="text-secondary mt-1">{{ $card['label'] }}</div>
                                </div>
                                <span
                                    class="position-absolute top-0 end-0 m-2 badge bg-{{ $card['color'] }} bg-opacity-75 text-white px-3 py-2 shadow-sm">
                                    {{ $card['badge'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Report Type Switcher -->
        <div class="mb-4 d-flex justify-content-center">
            <div class="btn-group shadow rounded-pill overflow-hidden" role="group" aria-label="Report Type Switcher">
                <button id="toggleInvoices" type="button"
                    class="btn btn-lg btn-outline-primary px-4 py-2 active d-flex align-items-center gap-2">
                    <i class="bi bi-receipt"></i>
                    <span>{{ __('words.Invoices Report') }}</span>
                </button>
                <button id="toggleFoods" type="button"
                    class="btn btn-lg btn-outline-success px-4 py-2 d-flex align-items-center gap-2">
                    <i class="bi bi-egg-fried"></i>
                    <span>{{ __('words.Ordered Foods Report') }}</span>
                </button>
            </div>
        </div>

        <!-- Invoices Report Section -->
        <div id="invoicesSection">
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border">
                <div class="d-flex align-items-center gap-3">
                    <span class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-bar-chart-line-fill fs-2 text-primary"></i>
                    </span>
                    <h4 class="text-primary fw-bold mb-0">{{ __('words.Invoices Summary') }}</h4>
                </div>
                <a href="{{ route('casher.report.export', array_merge(request()->all(), ['type' => 'invoices'])) }}"
                    class="btn btn-outline-danger d-flex align-items-center gap-2" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i>
                    <span>{{ __('words.Export PDF') }}</span>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle text-center mb-0" id="orderedFoodTable"
                        dir="rtl">
                        <thead class="bg-gradient bg-primary text-white rudaw-font">
                            <tr>
                                <th>{{ __('words.Invoice ID') }}</th>
                                <th>{{ __('words.Table Number') }}</th>
                                <th>{{ __('words.Cashier Name') }}</th>
                                <th>{{ __('words.Total Price') }}</th>
                                <th>{{ __('words.Status') }}</th>
                                <th>{{ __('words.Ordered At') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td class="fw-bold text-primary">{{ $invoice->id }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark px-3 py-2">
                                            {{ $invoice->table->table_number ?? __('words.N/A') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="fw-semibold">{{ $invoice->creator->username ?? __('words.Unknown') }}</span>
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">{{ number_format($invoice->total_price) }}
                                            {{ __('words.IQD') }}</span>
                                    </td>
                                    <td>
                                        @if ($invoice->status == 1)
                                            <span
                                                class="badge bg-warning text-dark px-3 py-2">{{ __('words.Unpaid') }}</span>
                                        @else
                                            <span class="badge bg-success px-3 py-2">{{ __('words.Paid') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $invoice->created_at->format('Y-m-d H:i') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        {{ __('words.No invoice records found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3 px-3 pb-3">
                        {{ $invoices->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Ordered Foods Report Section -->
        <div id="foodsSection" style="display: none;">

            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded-4 shadow-sm mb-4 border">
                <div class="d-flex align-items-center gap-3">

                    <h4 class="text-primary fw-bold mb-0">🍔 {{ __('words.Ordered Foods Summary') }}</h4>
                </div>

                <a href="{{ route('casher.reports.export.ordered_foods', array_merge(request()->all(), ['type' => 'ordered_foods'])) }}"
                    class="btn btn-outline-danger d-flex align-items-center gap-2" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> <span>{{ __('words.Export Ordered Foods') }}</span>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-borderless align-middle text-center mb-0" id="orderedFoodTable"
                        dir="rtl">
                        <thead class="bg-gradient bg-primary text-white rudaw-font">
                            <tr>
                                <th class="text-center">{{ __('words.Date') }}</th>
                                <th class="text-center">{{ __('words.Food Item') }}</th>
                                <th class="text-center">{{ __('words.Total Quantity') }}</th>
                                <th class="text-center">{{ __('words.Total Price') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($groupedFoodsPaginated as $row)
                                <tr>
                                    <td>{{ $row->date }}</td>
                                    <td>{{ $row->food->name_ckb ?? 'نەناسراو' }}</td>
                                    <td>{{ $row->total_quantity }}</td>
                                    <td>{{ number_format($row->total_revenue) }} {{ __('words.IQD') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No food data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $groupedFoodsPaginated->appends(request()->except('foods_page'))->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>

        </div>
    </div>


        <!-- Toggle JS -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const invoicesBtn = document.getElementById('toggleInvoices');
                const foodsBtn = document.getElementById('toggleFoods');
                const invoicesSection = document.getElementById('invoicesSection');
                const foodsSection = document.getElementById('foodsSection');

                function showSection(section) {
                    invoicesBtn.classList.toggle('active', section === 'invoices');
                    foodsBtn.classList.toggle('active', section === 'foods');
                    invoicesSection.style.display = section === 'invoices' ? 'block' : 'none';
                    foodsSection.style.display = section === 'foods' ? 'block' : 'none';
                }

                const sectionParam = new URLSearchParams(window.location.search).get('section') || 'invoices';
                showSection(sectionParam);

                invoicesBtn.addEventListener('click', () => showSection('invoices'));
                foodsBtn.addEventListener('click', () => showSection('foods'));
            });
        </script>
    @endsection
