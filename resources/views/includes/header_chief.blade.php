<header id="page-topbar" class="bg-primary text-white" style="height: 80px; font-family: 'Oswald', sans-serif;">
    <div class="container-fluid">
        <div class="row align-items-center">
            <!-- Logo Section -->
            <div class="col-6 col-md-4">
                <div class="navbar-brand-box">
                    <h2 class="text-white m-0">
                        <span style="color:rgb(255,183,0)">F</span>ood 
                        <span style="color: rgb(255, 183,0)">R</span>est
                    </h2>
                </div>
            </div>

            <!-- User Account Section -->
            <div class="col-6 col-md-8 text-end">
                <div class="d-flex align-items-center justify-content-end">
                    <!-- Account Name -->
                    <span class="me-3 fw-medium font-size-15">
                        {{ auth()->user()->name }}
                    </span>

                     <!-- Logout Button -->
                     <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="uil uil-sign-out-alt font-size-18 align-middle me-1 text-muted"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<aside id="slidebar" class="slidebar bg-light page-topbar" style="font-family: 'Oswald', sans-serif; width: 100%;">
    <nav class="admin-nav">
        <ul class="navbar-nav d-flex flex-row">
            
            <li class="nav-item">
            <a class="nav-link" href="{{ route('server.home') }}">
                <i class="fa fa-home"></i> Home 
            </a>
            </li>
            
            <li class="nav-item me-3">
                <a class="nav-link" href="{{ route('chief.foods.index') }}">
                    <i class="fas fa-hamburger"></i> Foods 
                </a>
            </li>
        </ul>
    </nav>
</aside>
