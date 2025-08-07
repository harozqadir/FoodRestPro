@auth
<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ar', 'ckb']) ? 'rtl' : 'ltr' }}">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Food Restaurant Admin - @yield('title', 'Dashboard')</title>

    <!-- Google Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Kurdish&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @if (in_array(app()->getLocale(), ['ar', 'ckb']))
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link rel="stylesheet" href="/css/bootstrap.min.css">
    @endif

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.3.2/datatables.min.css" rel="stylesheet" integrity="sha384-d76uxpdVr9QyCSR9vVSYdOAZeRzNUN8A4JVqUHBVXyGxZ+oOfrZVHC/1Y58mhyNg" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Custom & Template CSS Files -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/lightstyleen.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet" />

    @stack('styles')

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
</head>
<body data-layout="horizontal" data-topbar="colored">
    <div id="layout-wrapper">
        @include('includes.header_admin')
        <div class="d-flex">
            @include('includes.sidebar_admin', ['categories' => $categories])
            <div class="main-content w-100 px-0 mt-4 mb-8">
                <div class="page-content container-fluid px-2 px-md-4">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible mt-2 fade show" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row"></div>
            </div>
        </footer>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.min.js') }}"></script>

    <!-- External JS libs -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/printThis.js') }}" defer></script>
    <script src="{{ asset('js/select.js') }}" defer></script>
    <script src="{{ asset('online/sweetAlert.js') }}" defer></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>

    @stack('scripts')

    <script>
        // Initialize Select2
        $(document).ready(function () {
            $('select').select2();
        });

        // Dropdown hover for header and sidebar
        document.querySelectorAll('.dropdown > a').forEach(dropdown => {
            dropdown.addEventListener('mouseover', function () {
                const submenu = this.nextElementSibling;
                if (submenu) submenu.style.display = 'block';
            });
            dropdown.parentElement.addEventListener('mouseleave', function () {
                const submenu = this.querySelector('.dropdown-menu');
                if (submenu) submenu.style.display = 'none';
            });
        });

        // Dropdown submenu handling
        document.querySelectorAll('.dropdown-submenu > a').forEach(item => {
            item.addEventListener('mouseover', function () {
                const submenu = this.nextElementSibling;
                if (submenu) submenu.classList.add('show');
            });
            item.parentElement.addEventListener('mouseleave', function () {
                const submenu = this.querySelector('.dropdown-menu');
                if (submenu) submenu.classList.remove('show');
            });
        });

        document.querySelectorAll('.dropdown-submenu > a').forEach(el => {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                document.querySelectorAll('.sub-dropdown').forEach(m => m.style.display = 'none');
                submenu.style.display = 'block';
            });
        });

        // Handling user dropdown
        document.addEventListener("DOMContentLoaded", function () {
            const userDropdown = document.getElementById('userDropdown');
            if (userDropdown) {
                const dropdownMenu = userDropdown.nextElementSibling;
                let isDropdownOpen = false;

                userDropdown.addEventListener('click', function (e) {
                    e.stopPropagation();
                    if (!isDropdownOpen) {
                        dropdownMenu.classList.add('show');
                        isDropdownOpen = true;
                    }
                });

                document.addEventListener('mouseenter', function (e) {
                    if (!userDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        if (isDropdownOpen) {
                            dropdownMenu.classList.remove('show');
                            isDropdownOpen = false;
                        }
                    }
                });

                dropdownMenu.addEventListener('mouseenter', function () {
                    if (!isDropdownOpen) {
                        dropdownMenu.classList.add('show');
                        isDropdownOpen = true;
                    }
                });

                dropdownMenu.addEventListener('mouseleave', function () {
                    if (isDropdownOpen) {
                        dropdownMenu.classList.remove('show');
                        isDropdownOpen = false;
                    }
                });
            }
        });
        
    </script>
</body>
</html>
@endauth
