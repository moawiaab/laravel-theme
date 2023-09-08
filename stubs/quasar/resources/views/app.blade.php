<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        @font-face {
            font-family: myFirstFont;
            src: url({{ asset('Khalid-Art-Bold.ttf') }});
        }

        body {
            font-family: myFirstFont !important;
            /* color: darkgreen; */
            font-weight: bold
        }

        a {
            text-decoration: none !important
        }
    </style>
    <!-- Scripts -->
    @vite('resources/js/app.ts')
</head>

<body class="">

    <div id="app">

    </div>

</body>

</html>
