<!-- filepath: /Users/mohammed/Development/laravel/Foodrest/resources/views/includes/header.blade.php -->
<header id="page-topbar" class="bg-primary text-white" style="height: 80px;">
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

<aside id="slidebar" class="slidebar bg-light page-topbar">
    <nav class="admin-nav">
      
        <ul class="list-unstyled">
            <li>
                <a class="{{ in_array(Route::currentRouteName(), ['home']) ? 'active' : '' }}" href="{{ route('home') }}">
                    <i class="fa fa-home"></i> Dashboard
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button">
                    <i class="fa fa-users"></i> Users
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                    <div><a href="{{ route('admin.users.index') }}" class="dropdown-item">Show</a></div>
                    <div><a href="{{ route('admin.users.create') }}" class="dropdown-item">Create</a></div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button">
                    <i class="fa fa-list-alt"></i> Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                    <div><a href="{{ route('admin.categories.index') }}" class="dropdown-item">Show</a></div>
                    <div><a href="{{ route('admin.categories.create') }}" class="dropdown-item">Create</a></div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button">
                    <i class="fa fa-tags"></i> Sub Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                    <div><a href="{{ route('admin.sub-categories.index') }}" class="dropdown-item">Show</a></div>
                    <div><a href="{{ route('admin.sub-categories.create') }}" class="dropdown-item">Create</a></div>
                </div>
            </li>
            

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button">
                    <i class="uil-box me-2"></i> Foods
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                    @foreach ($sub_categories as $row)
                      <a href="{{ route('admin.foods.index', ['sub_category' => $row->id]) }}" class="dropdown-item"> {{$row->name_en}}</a> 
                    @endforeach
                    
                </div>
            </li>
        </ul>
    </nav>
</aside>