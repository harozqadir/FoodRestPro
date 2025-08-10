@extends('layouts.chef')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h2 class="fw-bold text-primary">{{ __('words.Categories') }}</h2>
        <div class="row g-4">
            @foreach ($categories as $category)
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 h-100 category-card" onclick="show_sub_categories({{ $category->id }})" style="cursor:pointer;">
                        <img src="{{ asset('categories-image/' . $category->image) }}" class="card-img-top" alt="" style="height:180px; object-fit:cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ $category->name_ckb }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="subCategoriesSection">
        <div class="row mt-5">
            @foreach ($sub_categories as $sub_category)
                <div class="category{{ $sub_category->category_id }} foods d-none mb-5">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('sub-categories-image/' . $sub_category->image) }}" class="rounded" style="width:60px; height:60px; object-fit:cover;" alt="">
                                <h4 class="ms-3 mb-0">{{ $sub_category->name_ckb }}</h4>
                            </div>
                            <div class="row g-4">
                                @foreach ($sub_category->foods as $row)
                                    <div class="col-md-3">
                                        <div class="card h-100 border-0 shadow-sm food-card">
                                            <div class="card-body d-flex flex-column justify-content-between">
                                                <div>
                                                    <h5 class="card-title">{{ $row->name_ckb }}</h5>
                                                    <p class="card-text text-muted">{{ number_format($row->price, 0, '.', ',') }} {{ __('words.IQD') }}</p>
                                                </div>
                                                <div class="mt-2">
                                                    <form action="{{route('chef.foods.update',['id' => $row->id])}}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-outline-primary btn-sm"><i class="fas fa-sync-alt"></i></button>
                                                    </form>
                                                    <span class="ms-2">
                                                        {{ __('words.Current status') }}:
                                                        @if ($row->is_active)
                                                            <span class="badge bg-success">{{ __('words.Available') }}</span>
                                                        @else
                                                            <span class="badge bg-warning text-dark">{{ __('words.Not Available') }}</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .category-card:hover, .food-card:hover {
        box-shadow: 0 0 20px rgba(0,0,0,0.12);
        transform: translateY(-2px) scale(1.02);
        transition: all 0.2s;
    }
</style>

<script>
    let show_sub_categories = (id) => {
        let foods = document.getElementsByClassName('foods');
        for (let i = 0; i < foods.length; i++) {
            foods[i].classList.add('d-none');
        }
        let sub_categories = document.getElementsByClassName('category' + id);
        for (let i = 0; i < sub_categories.length; i++) {
            sub_categories[i].classList.remove('d-none');
        }
        window.scrollTo({ top: document.getElementById('subCategoriesSection').offsetTop - 80, behavior: 'smooth' });
    }
</script>
@endsection
