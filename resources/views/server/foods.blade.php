@extends('layouts.server')

@section('content')
<div class="container my-5">

    <!-- Table and Invoice Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h2 class="text-primary">Table #{{ $table->table_number }}</h2>
            @if ($invoice)
                <h5 class="text-muted">Invoice ID: #{{ $invoice->id }}</h5>
                <form id="delete-invoice-form" action="{{ route('server.invoice.delete', ['id' => $invoice->id]) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="button" onclick="deleteFunction()" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> Delete Invoice
                    </button>
                </form>
            @endif
        </div>
        <a href="{{ route('server.home') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>

    <!-- Ordered Food Section -->
    @if ($invoice)
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle" id="orderedFoodTable">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Food Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->invoice_food as $row)
                    <tr>
                        <td>{{ $row->food->name_en }}</td>
                        <td>IQD {{ number_format($row->price, 0, '.', ',') }}</td>
                        <td class="text-center">{{ $row->quantity }}</td>
                        <td>IQD {{ number_format($row->quantity * $row->price, 0, '.', ',') }}</td>
                        <td class="text-center">
                            <form action="{{ route('server.foods.plus_or_minus', ['id' => $row->id, 'value' => 1]) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="Increase quantity">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                            <form action="{{ route('server.foods.plus_or_minus', ['id' => $row->id, 'value' => -1]) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="Decrease quantity">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Order Food Section -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Order Food</h4>
        </div>
        <div class="card-body">

            <!-- Category Cards -->
            <div class="row mb-4">
                @foreach ($sub_categories as $sub_category)
                    <div class="col-md-3 col-6 mb-3">
                        <div class="category-card p-4 text-center" onclick="showFoods({{ $sub_category->id }})" role="button" tabindex="0">
                            <h5 class="text-primary">{{ $sub_category->name_en }}</h5>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Subcategories and Foods Form -->
            <form action="{{ route('server.foods.store') }}" method="POST" id="orderForm">
                @csrf
                <input type="hidden" name="table_id" value="{{ $table->id }}">

                <!-- Foods per subcategory -->
                <div class="row">
                    @foreach ($sub_categories as $sub_category)
                        <div class="col-12 foods-container sub-category-{{ $sub_category->id }} d-none">
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body d-flex align-items-center">
                                    <img src="{{ asset('sub-categories-image/' . $sub_category->image) }}" alt="{{ $sub_category->name_en }}" class="col-3 rounded" style="object-fit:cover; max-height: 120px;">
                                    <h5 class="ms-4">{{ $sub_category->name_en }}</h5>
                                </div>
                                <div class="row mt-3">
                                    @foreach ($sub_category->foods as $food)
                                        <div class="col-md-4 col-6 mb-4 text-center">
                                            <div class="card food-item-card shadow-sm p-3">
                                                <p class="mb-2 text-dark fw-semibold">{{ $food->name_en }}</p>
                                                <p class="text-muted mb-3">{{ number_format($food->price, 0, '.', ',') }} IQD</p>
                                                <input type="hidden" name="food_id[]" value="{{ $food->id }}">
                                                <input type="hidden" name="price[]" value="{{ $food->price }}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <button type="button" class="btn btn-success btn-sm" onclick="increment({{ $food->id }})" aria-label="Add one {{ $food->name_en }}">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <input type="number" readonly id="food-{{ $food->id }}" name="quantity[]" class="form-control text-center" value="0" min="0" style="width: 60px;">
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="decrement({{ $food->id }})" aria-label="Remove one {{ $food->name_en }}">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total and Submit Order -->
                <div class="d-flex flex-column align-items-center mt-4">
                    <input type="text" readonly id="total" name="total" class="form-control text-center fw-bold" value="IQD 0" style="max-width: 300px;">
                    <button type="submit" class="btn btn-success btn-lg mt-3 w-100 w-md-auto" id="submitOrder" disabled>Order</button>
                    <button type="button" class="btn btn-danger btn-lg mt-3 w-100 w-md-auto" onclick="resetOrder()">Reset Order</button>
                </div>
            </form>

        </div>
    </div>

</div>

<!-- JavaScript Section -->
<script>
    // Initialize DataTable on ordered food table
    $(document).ready(function() {
        $('#orderedFoodTable').DataTable({
            paging: false,
            searching: false,
            info: false,
            ordering: false,
        });
    });

    // Show foods for selected subcategory with smooth transition
    function showFoods(subCategoryId) {
        const containers = document.querySelectorAll('.foods-container');
        containers.forEach(c => {
            if (c.classList.contains('sub-category-' + subCategoryId)) {
                c.classList.remove('d-none');
                c.style.opacity = 0;
                setTimeout(() => c.style.opacity = 1, 10);
            } else {
                c.style.opacity = 0;
                setTimeout(() => c.classList.add('d-none'), 300);
            }
        });
    }

    // Format IQD currency
    function formatCurrency(amount) {
        return 'IQD ' + amount.toLocaleString();
    }

    // Update total price and enable/disable submit button
    function updateTotal() {
        let total = 0;
        let totalQuantity = 0;
        document.querySelectorAll('input[name="quantity[]"]').forEach((input, idx) => {
            let quantity = parseInt(input.value);
            let price = parseFloat(document.querySelectorAll('input[name="price[]"]')[idx].value);
            total += quantity * price;
            totalQuantity += quantity;
        });
        document.getElementById('total').value = formatCurrency(total);

        // Enable submit only if quantity > 0
        document.getElementById('submitOrder').disabled = totalQuantity === 0;
    }

    // Increment quantity
    function increment(foodId) {
        const input = document.getElementById('food-' + foodId);
        if (input) {
            input.value = parseInt(input.value) + 1;
            updateTotal();
        }
    }

    // Decrement quantity
    function decrement(foodId) {
        const input = document.getElementById('food-' + foodId);
        if (input && parseInt(input.value) > 0) {
            input.value = parseInt(input.value) - 1;
            updateTotal();
        }
    }

    // Reset order quantities and total
    function resetOrder() {
        document.querySelectorAll('input[name="quantity[]"]').forEach(input => input.value = 0);
        updateTotal();
    }

    // Confirmation dialog for invoice deletion
    function deleteFunction() {
        Swal.fire({
            title: 'Are you sure to delete this invoice?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Deleted!', 'Invoice has been deleted.', 'success');
                setTimeout(() => {
                    document.getElementById('delete-invoice-form').submit();
                }, 700);
            }
        });
    }
</script>
@endsection
