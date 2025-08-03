@auth
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Food Restaurant Admin - @yield('title', 'Dashboard')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald&family=Inter:wght@400;600&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/v/dt/dt-2.3.2/datatables.min.css" rel="stylesheet" integrity="sha384-d76uxpdVr9QyCSR9vVSYdOAZeRzNUN8A4JVqUHBVXyGxZ+oOfrZVHC/1Y58mhyNg" crossorigin="anonymous">

    <!-- Custom & Template CSS Files -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/lightstyleen.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    @stack('styles') <!-- Additional custom styles -->
</head>

<body data-layout="horizantal" data-topbar="colored">
    <div id="layout-wrapper">

        @include('includes.header_server')

        <!-- Sidebar with -->
        <div class="d-flex">
            @include('includes.sidebar_server')

            <div class="main-content w-100 px-0 mt-4 mb-8">
                <div class="page-content container-fluid px-2 px-md-4">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible mt-2 fade show" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mt-5">
                        @yield('content')
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row"></div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
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
    let deleteFunction = (invoiceId) => {
        Swal.fire({
            title: 'Are you sure you want to delete this invoice?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Show success message
                Swal.fire(
                    'Deleted!',
                    'Invoice has been deleted successfully.',
                    'success'
                );

                // Submit the form after the confirmation with a slight delay
                setTimeout(() => {
                    document.getElementById('delete-form-' + invoiceId).submit();
                }, 500);
            }
        });
    };

        
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

       
        

        
    </script>
</body>

</html>
@endauth
