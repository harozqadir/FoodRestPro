@extends('layouts.casher')



@section('content')
<div class="container mt-4">

    <div class="mb-4">
        <h2 class="fw-bold text-primary">📊 Cashier Report Dashboard</h2>
    </div>

    <!-- Filter Form -->
    <form method="GET" class="row g-3 bg-light p-4 rounded shadow-sm mb-4">
        <div class="col-md-3">
            <label for="start_date" class="form-label fw-semibold">Start Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label fw-semibold">End Date</label>
            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
       
        <div class="col-md-3">
    <label for="cashier_id" class="form-label fw-semibold">Cashier</label>
    <select name="cashier_id" id="cashier_id" class="form-select">
        <option value="">All</option>
        @foreach($cashiers as $cashier)
            <option value="{{ $cashier->id }}" {{ request('cashier_id') == $cashier->id ? 'selected' : '' }}>
                {{ $cashier->username }}
            </option>
        @endforeach
    </select>
</div>
        <div class="col-12 d-flex justify-content-between mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-funnel-fill"></i> Apply Filters
            </button>
            <a href="{{ route('casher.reports') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Clear Filters
            </a>
        </div>
    </form>

    <!-- Report Type Buttons -->
    <div class="mb-3 d-flex gap-3">
        <button id="toggleInvoices" class="btn btn-outline-primary active">Invoices Report</button>
        <button id="toggleFoods" class="btn btn-outline-success">Ordered Foods Report</button>
    </div>

    <!-- Invoices Report -->
    <div id="invoicesSection">
            <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded shadow-sm mb-3">
            <h4 class="text-primary fw-bold mb-0">🧾 Invoices Summary</h4>
            <form method="GET" action="{{ route('casher.report.export') }}" target="_blank" class="mb-3">
               <input type="hidden" name="start_date" value="{{ request('start_date') }}">
               <input type="hidden" name="end_date" value="{{ request('end_date') }}">
               <input type="hidden" name="cashier_id" value="{{ request('cashier_id') }}">
               <button type="submit" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
              </button>
          </form>
          </div>

            <div class="mb-4">
            <div class="row text-center fw-semibold">
                <div class="col-md-4 text-success">Total Sales: IQD {{ number_format($totalSales) }}</div>
                <div class="col-md-4 text-info">Invoices: {{ $totalInvoices }}</div>
                <div class="col-md-4 text-danger">Unpaid: {{ $unpaidInvoices }}</div>
               </div>
             </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Invoice ID</th>
                        <th>Table Number</th>
                        <th>Cashier Name</th>
                        <th>Total Price< IQD</th>
                        <th>Status</th>
                        <th>Ordered At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>Table {{ $invoice->table->table_number ?? 'N/A' }}</td>
                            <td>{{ $invoice->creator->username ?? 'Unknown' }}</td>
                            <td>IQD {{ number_format($invoice->total_price) }}</td>
                            <td>
                                 @if($invoice->status == 1)
                                    <span class="badge bg-warning text-dark">Unpaid</span>
                                @else
                                    <span class="badge bg-success">Paid</span>
                                @endif
                            </td>
                            <td>{{ $invoice->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No invoice records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $invoices->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Ordered Foods Report -->
    <div id="foodsSection" style="display: none;">
        <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded shadow-sm mb-3">
            <h4 class="text-success fw-bold mb-0">🍔 Ordered Foods Summary</h4>
            <a href="{{ route('casher.reports.export.ordered_foods', array_merge(request()->all(), ['type' => 'ordered_foods'])) }}"
   class="btn btn-outline-danger" target="_blank">
    <i class="bi bi-file-earmark-pdf"></i> Export PDF
</a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Food Item</th>
                        <th>Total Quantity</th>
                        <th>Total Price (IQD)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groupedFoodsPaginated as $row)
                        <tr>
                            <td>{{ $row->date }}</td>
                            <td>{{ $row->food->name_en ?? 'Unknown' }}</td>
                            <td>{{ $row->total_quantity }}</td>
                            <td>IQD {{ number_format($row->total_revenue) }}</td>
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

<!-- Toggle JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const invoicesBtn = document.getElementById('toggleInvoices');
    const foodsBtn = document.getElementById('toggleFoods');
    const invoicesSection = document.getElementById('invoicesSection');
    const foodsSection = document.getElementById('foodsSection');

    function showSection(section) {
        if (section === 'foods') {
            invoicesBtn.classList.remove('active');
            foodsBtn.classList.add('active');
            invoicesSection.style.display = 'none';
            foodsSection.style.display = 'block';
        } else {
            invoicesBtn.classList.add('active');
            foodsBtn.classList.remove('active');
            invoicesSection.style.display = 'block';
            foodsSection.style.display = 'none';
        }
    }

    const sectionParam = new URLSearchParams(window.location.search).get('section') || 'invoices';
    showSection(sectionParam);

    invoicesBtn.addEventListener('click', () => showSection('invoices'));
    foodsBtn.addEventListener('click', () => showSection('foods'));
});
</script>
@endsection
