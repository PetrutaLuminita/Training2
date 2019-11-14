<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('Training') }}</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @yield('stylesheets')

        <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        @yield('scripts')
    </head>
    <body>
        <?php if (Route::has('login')) : ?>
            <div class="top-right links">
                <?php if (session('admin')) : ?>
                    <a href="{{ route('admin.products.index') }}">{{ __('All products') }}</a>
                <?php else : ?>
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                <?php endif ?>
            </div>
        <?php endif ?>

        <div class="content">
            <div class="title m-b-md">
                @yield('title')
            </div>

            <div class="container text-center">
                @yield('content')
            </div>
        </div>
    </body>
</html>
