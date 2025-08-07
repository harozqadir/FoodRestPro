@extends('layouts.server')

@section('content')
<div class="container py-5">

    <!-- Table & Invoice Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h2 class="text-primary fw-bold mb-1">
                <i class="fas fa-utensils me-2"></i>{{ __('words.Table') }} <span class="rudaw-font">{{ $table->table_number }}</span>
            </h2>
            @if ($invoice)
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-dark me-2">{{ __('words.Invoice ID') }}: {{ $invoice->id }}</span>
                    <form id="delete-invoice-form" action="{{ route('server.invoice.delete', ['id' => $invoice->id]) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="button" onclick="deleteFunction()" class="btn btn-outline-danger btn-sm ms-2" data-bs-toggle="tooltip" title="{{ __('words.Delete Invoice') }}">
                            <i class="fas fa-trash"></i>{{ __('words.Delete Invoice') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
        <a href="{{ route('server.home') }}" class="btn btn-outline-success d-flex align-items-center">
            <i class="fas fa-arrow-left me-2"></i> <span class="fw-semibold">{{ __('words.Back') }}</span>
        </a>
    </div>

    <!-- Food Categories -->
    <div class="row mb-4">
        @foreach ($sub_categories as $sub_category)
            <div class="col-lg-3  col-8 mb-1">
                <div class="card category-card shadow-sm border-0 h-100" onclick="showFoods({{ $sub_category->id }})" role="button" tabindex="0" style="cursor:pointer; transition:transform .2s;">
                    <div class="ratio ratio-1x1">
                        <img src="{{ asset('sub-categories-image/' . ($sub_category->image ?? 'default.png')) }}" class="card-img-top rounded-top w-100 h-100" alt="{{ $sub_category->name_ckb }}" style="object-fit:cover;">
                    </div>
                    <div class="card-body text-center p-2">
                        <h6 class="card-title text-primary fw-bold mb-0">{{ $sub_category->name_ckb }}</h6>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Food Order Form -->
    <form action="{{ route('server.foods.store') }}" method="POST" id="orderForm">
        @csrf
        <input type="hidden" name="table_id" value="{{ $table->id }}">
        <div class="row">
            @foreach ($sub_categories as $sub_category)
                <div class="col-12 foods-container sub-category-{{ $sub_category->id }} d-none">
                    <div class="row">
                        @foreach ($sub_category->foods as $food)
                            <div class="col-lg-3 col-md-4 col-6 mb-4">
                                <div class="card food-item-card shadow-sm border-0 h-100">
                                    <img src="{{ asset('foods-image/' . ($food->image ?? 'default.png')) }}" class="card-img-top rounded-top" alt="{{ $food->name_ckb }}" style="height:120px; object-fit:cover;">
                                    <div class="card-body text-center p-2">
                                        <h6 class="fw-bold mb-1">{{ $food->name_ckb }}</h6>
                                        <p class="text-muted mb-2">{{ number_format($food->price, 0, '.', ',') }} {{ __('WORDS.IQD') }}</p>
                                        <input type="hidden" name="food_id[]" value="{{ $food->id }}">
                                        <input type="hidden" name="price[]" value="{{ $food->price }}">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="decrement({{ $food->id }})">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" readonly id="food-{{ $food->id }}" name="quantity[]" class="form-control text-center" value="0" min="0" style="width: 50px;">
                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="increment({{ $food->id }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex flex-column align-items-center mt-4">
            <input type="text" readonly id="total" name="total" class="form-control text-center fw-bold mb-2" value="0 {{__('words.IQD')}}" style="max-width: 300px;" dir="rtl">
            <div class="d-flex gap-2 w-100 justify-content-center">
                <button type="submit" class="btn btn-success btn-lg" id="submitOrder" disabled>{{__('words.Order')}}</button>
                <button type="button" class="btn btn-outline-danger btn-lg" onclick="resetOrder()">{{__('words.Reset Order')}}</button>
            </div>
        </div>
    </form>

    <!-- Ordered Food Section -->
    @if ($invoice)
    <div class="card shadow rounded mb-4">
        <div class="card-header bg-gradient bg-primary text-white">
            <h5 class="mb-0">{{ __('words.Ordered Foods') }}</h5>
        </div>
        <div class="card-body table-responsive" dir="rtl">
            <table class="table table-bordered table-hover align-middle text-center mb-2 w-100" id="orderedFoodTable" dir="rtl">
                <thead class="rudaw-font">
                    <tr>
                        <th>#</th>
                        <th>{{ __('words.Food Name') }}</th>
                        <th>{{ __('words.Price') }}</th>
                        <th>{{ __('words.Quantity') }}</th>
                        <th>{{ __('words.Total Price') }}</th>
                        <th>{{ __('words.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->invoice_food as $index => $row)
                    <tr>
                        <td class="fw-bold align-middle">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($row->food->image)
                                    <img src="{{ asset('foods-image/' . $row->food->image) }}" alt="{{ $row->food->name_ckb }}" class="rounded-circle border border-2" style="width:44px; height:44px; object-fit:cover;">
                                @endif
                                <span class="fw-semibold rudaw-font">{{ $row->food->name_ckb }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2 shadow-sm">
                              {{ number_format($row->price, 0, '.', ',') }}  {{__('WORDS.IQD')}}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-primary fs-6 px-3 py-2">{{ $row->quantity }}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary text-light fs-6 px-3 py-2 shadow-sm">
                              {{ number_format($row->quantity * $row->price, 0, '.', ',') }}  {{__('WORDS.IQD')}}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <form action="{{ route('server.foods.plus_or_minus', ['id' => $row->id, 'value' => -1]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="{{ __('words.Decrease quantity') }}">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </form>
                                <span class="fw-bold fs-5 px-2">{{ $row->quantity }}</span>
                                <form action="{{ route('server.foods.plus_or_minus', ['id' => $row->id, 'value' => 1]) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm" title="{{ __('words.Increase quantity') }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-secondary">
                        <td colspan="3" class="text-end fw-bold align-middle">
                            <span class="me-2">{{ __('words.Total Price') }}</span>
                        </td>
                        <td class="text-center fw-bold align-middle">
                            <span class="badge bg-primary fs-6 px-3 py-2">{{ $invoice->invoice_food->sum('quantity') }}</span>
                        </td>
                        <td class="text-end fw-bold text-success align-middle">
                            <span class="badge bg-success fs-6 px-3 py-2">
                                <i class="fas fa-money-bill-wave me-1"></i>
                                {{__('words.IQD')}} {{ number_format($invoice->invoice_food->sum(function($row){ return $row->quantity * $row->price; }), 0, '.', ',') }}
                            </span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endif

</div>

<!-- JavaScript Section -->
<script>
    function showFoods(subCategoryId) {
        document.querySelectorAll('.foods-container').forEach(c => {
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

    function formatCurrency(amount) {
        return amount.toLocaleString() + ' {{__('words.IQD')}}';
    }

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
        document.getElementById('submitOrder').disabled = totalQuantity === 0;
    }

    function increment(foodId) {
        const input = document.getElementById('food-' + foodId);
        if (input) {
            input.value = parseInt(input.value) + 1;
            updateTotal();
        }
    }

    function decrement(foodId) {
        const input = document.getElementById('food-' + foodId);
        if (input && parseInt(input.value) > 0) {
            input.value = parseInt(input.value) - 1;
            updateTotal();
        }
    }

    function resetOrder() {
        document.querySelectorAll('input[name="quantity[]"]').forEach(input => input.value = 0);
        updateTotal();
    }

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

    document.addEventListener('DOMContentLoaded', updateTotal);
</script>
@endsection
