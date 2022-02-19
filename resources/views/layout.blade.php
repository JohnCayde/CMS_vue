<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>John Cayde | Project - Simple CMS</title>
        <meta name="description" content="Welcome to my ERP project. {{__('messages.project_desc_2')}}">
        <meta name="author" content="John Cayde">
        <meta name="keywords" content="John Cayde, Portfolio, CMS, Content Management System">
        
        <link rel="stylesheet" href={{ asset('css/main/app-bs.css') }}>
        <script src={{ asset('js/main/app-bs.js') }} defer></script>

        @yield('script')
    </head>
    <body>
        <div class="container-fluid bg-dark">
            <div class="w-100 d-flex justify-content-between p-2">
                <a href="/" class="m-2 px-1 text-white text-decoration-none">Home</a>
                <div class="py-2">
                    <a href="/projects/c4ca4238a0b923820dcc509a6f75849b/howto" class="m-2 px-1 text-white  text-decoration-none">How to Play</a>
                    <a href="/projects/c4ca4238a0b923820dcc509a6f75849b/config" class="m-2 px-4 text-white  text-decoration-none">Config</a>
                    <a href="/projects/c4ca4238a0b923820dcc509a6f75849b/preview" class="m-2 px-4 text-white  text-decoration-none">Preview</a>
                </div>
                <form action="/logout" method="post">
                    @csrf
                    <button class="btn btn-dark">Log out</button>
                </form>
            </div>
        </div>

        @yield('main')
    </body>
</html>
