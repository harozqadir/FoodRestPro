@auth()
    <!doctype html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        

        <title>Food Restaurant Admin</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->

        <!-- Fonts -->

        <script src="{{ asset('online/jquery.min.js') }}"></script>
        <script src="{{ asset('online/axios.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ asset('online/jquery.datatable.min.css') }}">
        <script type="text/javascript" charset="utf8" src="{{ asset('online/jquery-3.3.1.js') }}"></script>
        <script type="text/javascript" charset="utf8" src="{{ asset('online/datatable.js') }}"></script>
        <!-- Styles -->

        <link href="{{ asset('online/fonta.css') }}" rel="stylesheet">
        <script src="{{ asset('online/sweetAlert.js') }}" defer></script>

        <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
        <script src="{{ asset('js/printThis.js') }}" defer></script>
        <script src="{{ asset('js/select.js') }}" defer></script>

        <!-- Vendor CSS Files -->
        <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       
        {{-- //install DataTable.net --}}
       <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
       <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/js/dataTables.min.js">
        
       <!-- App CSS -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Template Main CSS File -->
        <link href="{{ asset('assets/css/lightstyleen.css') }}" rel="stylesheet">

        <style>
            .btn-danger {
                background-color: rgb(167, 53, 53) !important
            }

            *::-webkit-scrollbar {
                width: 5px;
                height: 5px
            }

            *::-webkit-scrollbar-thumb {
                background: rgb(126, 126, 126)
            }
        </style>
        <script>
            $(document).ready(function(){
                $('.dropdown-toggle').click(function(e){
                    e.preventDefault(); // Prevent the default link behavior
                    $(this).next('.dropdown-menu').slideToggle(); // Toggle the vertical dropdown
                });
            });
        </script>
    </head>

    <body data-layout="horizantal" data-topbar="colored" >

        <div id="lauout-wrapper" >
            @include('includes.header')
            <aside id="slidebar" class="slidebar">
                <nav class="admin-nav">
                    <ul>
                        <li>
                            <a class="{{ in_array(Route::currentRouteName(), ['home']) }}" href="{{ route('home') }}">
                                <i class="fa fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle">
                                <i class="fa fa-users"></i> Users
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('admin.users.index') }}">Show</a></li>
                                <li><a href="{{ route('admin.users.create') }}">Create</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </aside>
            <div class="main-content">
                
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible mt-2 fade show" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                     
                    <div class="page-content" style="margin-top:0px">
                    @yield('content')
                </div>
                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row"></div>
                    </div>
                </footer>

            </div>

        </div>


        <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
        <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <!-- Template Main JS File -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

     <!-- App js-->
     <script src="assets/js/app.js"></script>

    </html>

    <script>
        let deleteFunction=(id)=>{
                Swal.fire({
                    title: 'Are you sure to delete this?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',


                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                        'Deleted!',
                        'Deleted Successfully',
                        'success'
                        );
                     setTimeout(() => {
                        document.getElementById(id).submit();

                     }, 500);

                    }
                })
        };

    </script>

<script>

</script>
@endauth
