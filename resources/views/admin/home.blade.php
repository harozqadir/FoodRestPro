@extends('layouts.admin')

@section('content')

<div class="container-fluid py-4">
    <div class="row g-3 justify-content-center" style="max-width:1200px; margin: 0 auto;">

        <!-- Users Card -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-lg border-primary animate__animated animate__fadeInUp h-100">
                <div class="card-header bg-primary d-flex align-items-center justify-content-between text-white py-3 px-4">
                    <h5 class="card-title text-light mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-users fa-lg"></i> Users
                    </h5>
                    <i class="fas fa-user-circle fa-lg text-white"></i>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-primary p-4">
                    <div class="display-1 opacity-10 mb-3"><i class="fas fa-users"></i></div>
                    <p class="text-center fs-6 fw-semibold mb-2">
                        Total users currently registered in the system.
                    </p>
                    <h2 class="fw-bold mb-0">{{ $userCount }} Users</h2>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-lg border-warning animate__animated animate__fadeInUp h-100">
                <div class="card-header bg-warning d-flex align-items-center justify-content-between text-white py-3 px-4">
                    <h5 class="card-title text-light mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-th-list fa-lg"></i> Categories
                    </h5>
                    <i class="fas fa-folder-open fa-lg text-white"></i>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-warning p-4 position-relative">
                    <div class="display-1 opacity-10 mb-3"><i class="fas fa-th-list"></i></div>
                    <p class="text-dark fs-6 fw-semibold mb-2 text-center">
                        Total categories currently available.
                    </p>
                    <h2 class="fw-semibold mb-0">{{ $categoryCount }}</h2>
                </div>
            </div>
        </div>

        <!-- Foods Card -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-lg border-info animate__animated animate__fadeInUp h-100">
                <div class="card-header bg-info text-white d-flex align-items-center justify-content-between py-3 px-4">
                    <h5 class="card-title text-light mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-pizza-slice me-2"></i> Foods Snapshot
                    </h5>
                    <i class="fas fa-utensils fa-lg text-white"></i>
                </div>
                <div class="card-body d-flex flex-column justify-content-between pb-3 px-4">
                    <div class="text-center mb-4">
                        <h2 class="display-4 fw-extrabold text-info mb-1">{{ $foodCount ?? 0 }}</h2>
                        <p class="text-muted text-uppercase mb-0 fs-6">Total Menu Items</p>
                    </div>
                    <div class="mb-4 px-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-success fw-semibold">Active: {{ $activeCount ?? 0 }}</span>
                            <span class="text-secondary fw-semibold">Inactive: {{ $inactiveCount ?? 0 }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            @php
                                $total = ($activeCount + $inactiveCount);
                                $activePercentage = $total > 0 ? ($activeCount / $total) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $activePercentage }}%;" aria-valuenow="{{ $activePercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="border-top pt-3 px-2">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="text-muted me-2">Most Expensive:</small>
                            <div class="text-end">
                                <strong class="text-dark">{{ $mostExpensiveName ?? 'N/A' }}</strong>
                                <span class="d-block text-info fw-bold">{{ number_format($mostExpensivePrice ?? 0, 0) }} IQD</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted me-2">Cheapest:</small>
                            <div class="text-end">
                                <strong class="text-dark">{{ $cheapestName ?? 'N/A' }}</strong>
                                <span class="d-block text-warning fw-bold">{{ number_format($cheapestPrice ?? 0, 0) }} IQD</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub-Categories Card -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-lg border-danger animate__animated animate__fadeInUp h-100">
                <div class="card-header  bg-danger d-flex align-items-center justify-content-between text-white py-3 px-4">
                    <h5 class="card-title text-light mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-cogs fa-lg"></i> Sub-Categories
                    </h5>
                    <i class="fas fa-layer-group fa-lg text-white"></i>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-danger p-4 position-relative">
                    <div class="display-1 opacity-10 mb-3"><i class="fas fa-cogs"></i></div>
                    <p class="text-uppercase mb-2 fs-6 fw-semibold text-muted text-center">
                        Total sub-categories configured.
                    </p>
                    <h2 class="fw-semibold mb-0">{{ $subcategoryCount }}</h2>
                </div>
            </div>
        </div>

        <!-- Reservations Card -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-lg border-success animate__animated animate__fadeInUp h-100">
                <div class="card-header bg-success text-white d-flex align-items-center justify-content-between py-3 px-4">
                    <h5 class="card-title text-light mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-calendar-check me-2"></i> Reservations
                    </h5>
                    <i class="fas fa-chair fa-lg text-white"></i>
                </div>
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fa fa-calendar-check fa-5x text-success mb-3"></i>
                    <h2 class="fw-bold mb-3">{{ $availableTableCount }} - Tables</h2>
                    <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-success btn-lg">Manage Reservation</a>
                </div>
            </div>
        </div>

        <!-- Developer Info Card -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card shadow-lg border-info animate__animated animate__fadeInUp h-100">
                <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between py-3 px-4">
                    <h5 class="card-title text-light mb-0 fw-bold d-flex align-items-center gap-2">
                        <i class="fas fa-user-secret me-2"></i> Developer Info
                    </h5>
                    <i class="fas fa-code fa-lg text-white"></i>
                </div>
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-4">
                    <i class="fa fa-info-circle fa-4x text-dark mb-3"></i>
                    <h3 class="fw-bold mb-2">John Doe</h3>
                    <p class="text-muted mb-3">Full Stack Developer | Laravel Enthusiast</p>
                    <h5 class="text-dark">Skills & Technologies:</h5>
                    <ul class="list-unstyled mb-4">
                        <li><i class="fa fa-check-circle text-success me-2"></i> Laravel | MySQL</li>
                        <li><i class="fa fa-check-circle text-success me-2"></i> JavaScript / PHP</li>
                    </ul>
                    <p class="text-dark mb-1">Contact Us:</p>
                    <h6><i class="fa fa-envelope me-2"></i> johndoe@example.com</h6>
                    <h6><i class="fa fa-phone me-2"></i> +964 770 123 4567</h6>
                    <h6><i class="fa fa-globe me-2"></i> www.johndoe.com</h6>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
