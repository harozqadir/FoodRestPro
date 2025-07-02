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
        <ul class="list-unstyled">
            <li>
                <a class="{{ in_array(Route::currentRouteName(), ['admin.home']) ? 'active' : '' }}" href="{{ route('admin.home') }}">
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
                    <i class="fa fa-folder"></i> Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                    <div><a href="{{ route('admin.categories.index') }}" class="dropdown-item">Show</a></div>
                    <div><a href="{{ route('admin.categories.create') }}" class="dropdown-item">Create</a></div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button">
                    <i class="fa fa-sitemap"></i> Sub Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                    <div><a href="{{ route('admin.sub-categories.index') }}" class="dropdown-item">Show</a></div>
                    <div><a href="{{ route('admin.sub-categories.create') }}" class="dropdown-item">Create</a></div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button">
                    <i class="fa fa-chair me-2"></i> Tables
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                    <div><a href="{{ route('admin.tables.index') }}" class="dropdown-item">Show</a></div>
                    <div><a href="{{ route('admin.tables.create') }}" class="dropdown-item">Create</a></div>
                </div>
            </li>
             
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle arrow-none" id="topnav-pages" role="button">
                    <i class="fa fa-cutlery"></i> Foods <div class="arrow-down"></div>
                </a>
                <div class="dropdown-menu" aria-labelledby="topnav-pages">
                    @foreach ($categories as $category)
                        <div class="dropdown" style="margin-right: 20px; position: relative;">
                            <a id="topnav-form-{{ $category->id }}" role="button" href="#" class="dropdown-item">
                                {{ $category->name_en }}
                                <i class="fa fa-angle-right ms-2 fw-bold"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="topnav-form-{{ $category->id }}" style="position: absolute; left: 100%; top: 0; display: none;">
                                @foreach ($category->sub_categories as $sub)
                                    <a href="{{ route('admin.foods.index', ['sub_category' => $sub->id]) }}" class="dropdown-item">
                                        {{ $sub->name_en }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </li>
        </ul>
    </nav>
</aside>
<script>
    document.querySelectorAll('.dropdown').forEach(function(drop){
    drop.addEventListener('mouseenter', function(){
        let submenu = drop.querySelector('.dropdown-menu');
        if(submenu) submenu.style.display = 'block';
    });
    drop.addEventListener('mouseleave', function(){
        let submenu = drop.querySelector('.dropdown-menu');
        if(submenu) submenu.style.display = 'none';
    });
});
</script>