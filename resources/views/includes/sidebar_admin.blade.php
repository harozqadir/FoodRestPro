<aside class="col-auto col-md-3 col-lg-2 px-sm-2 px-8 bg-white border-end shadow-sm" style="font-family: 'Inter', sans-serif;">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2" style="display: flex; flex-direction: column; height: auto;">

        {{-- Header Section --}}
        <div class="card w-100 mb-3">
            <div class="card-header text-center" style="font-family: 'Montserrat', sans-serif; font-size: 22px;">
                 <!-- User Avatar -->
                <img src="/icons/avatar.png" class="rounded-circle" width="50" height="50" alt="user-avatar">
                <h4 class="fw-bold mt-2" style="font-size: 24px;">{{ auth()->user()->username }}</h4>
                <small class="text-muted" style="font-size: 16px;">{{ auth()->user()->role == 1 ? 'Admin' : 'User' }}</small>

               
            </div>
        </div>

        <div class="card-body text-center" style="font-family: 'Montserrat', sans-serif; font-size: 22px;">
               <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu" style="font-family: 'Roboto', sans-serif; font-size: 18px;">
            <!-- Dashboard -->
            <li class="nav-item w-100 mb-3 mt-2">
                <a href="{{ route('admin.home') }}" class="nav-link px-0 align-middle text-dark d-flex align-items-center ">
                    <i class="fa fa-home me-2" style="font-size: 18px;"></i>
                    <span class="ms-1 d-none d-sm-inline" style="font-size: 22px;">Dashboard</span>
                </a>
            </li>

           

<!-- Users -->
<li class="nav-item w-100 mb-3 mt-2">
    <a href="{{ route('admin.users.index') }}" class="nav-link px-0 align-middle text-dark d-flex align-items-center" style="font-size: 18px;">
        <i class="fa fa-users me-2" style="font-size: 22px;"></i>
        <span>Users</span>
    </a>
</li>

<!-- Categories -->
<li class="nav-item w-100 mb-3 mt-2">
    <a href="{{ route('admin.categories.index') }}" class="nav-link px-0 align-middle text-dark d-flex align-items-center" style="font-size: 18px;">
        <i class="fa fa-folder me-2" style="font-size: 22px;"></i>
        <span>Category</span>
    </a>
</li>


<!-- Sub Categories -->
<li class="nav-item w-100 mb-3 mt-2">
    <a href="{{ route('admin.sub-categories.index') }}" class="nav-link px-0 align-middle text-dark d-flex align-items-center" style="font-size: 18px;">
        <i class="fa fa-sitemap me-2" style="font-size: 22px;"></i>
        <span>Sub Categories</span>
    </a>
</li>
            
<!-- Tables -->
<li class="nav-item w-100 mb-3 mt-2">
    <a href="{{ route('admin.tables.create') }}" class="nav-link px-0 align-middle text-dark d-flex align-items-center" style="font-size: 18px;">
        <i class="fa fa-chair me-2" style="font-size: 22px;"></i>
        <span>Tables</span>
    </a>
</li>


            <!-- Foods -->
<li class="nav-item w-100 mb-3 mt-2">
 
    <a href="{{ route('admin.foods.index') }}" class="nav-link px-0 align-middle text-dark d-flex align-items-center" style="font-size: 18px;">
        <i class="fas fa-utensils me-2" style="font-size: 22px;"></i> Foods
    </a>
</li>
    


        </ul>

<!-- Logout Button (at the bottom of the sidebar) -->
        <div class="mt-auto w-100">
            <form method="POST" action="{{ route('logout') }}" class="w-100">
                @csrf
                <button type="submit" class="btn btn-danger w-100 py-2" style="font-size: 18px;">
                    <i class="fa fa-sign-out-alt me-2" style="font-size: 20px;"></i> Logout
                </button>
            </form>
        </div>
        </footer>
        
    
</aside>