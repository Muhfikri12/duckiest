<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>

    @vite('resources/css/app.css')
        @vite('resources/js/app.js')
</head>

<body class="container">

    <x-navbar></x-navbar>

    {{ $slot }}

    <x-footer></x-footer>


</body>

</html>
