<!-- resources/views/components/admin/header.blade.php -->

<header class="admin-header">
    <div class="header-left">
        <span class="logo">Food <span style="color: orange;">Rest</span></span>
    </div>
    <div class="header-right">
        @auth
            <span class="user-email">{{ Auth::user()->email }}</span>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        @endauth
        @guest
            <a href="{{ route('login') }}" class="login-btn">Login</a>
        @endguest
    </div>
</header>





