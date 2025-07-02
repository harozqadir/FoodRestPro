<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
            <script src="{{ asset('js/app.js') }}" defer></script>
        @else
            <style>
                /* Minimal TailwindCSS styles for basic layout */
                body {
                    font-family: Figtree, sans-serif;
                    margin: 0;
                    background-color: #000;
                    color: #fff;
                }
                .container {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    min-height: 100vh;
                }
                .header, .footer {
                    text-align: center;
                }
                .link {
                    margin: 0.5rem;
                    padding: 0.5rem 1rem;
                    border: 1px solid transparent;
                    border-radius: 0.375rem;
                    text-decoration: none;
                    color: #fff;
                    transition: color 0.3s, border-color 0.3s;
                }
                .link:hover {
                    color: #FF2D20;
                    border-color: #FF2D20;
                }
            </style>
        @endif
    </head>
    <body>
        <div class="container">
            <header class="header">
                <h1>Welcome to Laravel</h1>
                @if (Route::has('login'))
                    <nav>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="link">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="link">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="link">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main>
                <section>
                    <a href="https://laravel.com/docs" class="link">Documentation</a>
                    <a href="https://laracasts.com" class="link">Laracasts</a>
                    <a href="https://laravel-news.com" class="link">Laravel News</a>
                </section>
            </main>

            <footer class="footer">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </footer>
        </div>
    </body>
</html>
