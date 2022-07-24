<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <!-- Google Fonts Inter & Source+Sans+Pro-->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abhaya+Libre:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link href="{{ asset('css/react-bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('react/css/font-awsome.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('react/css/style.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('react/css/custom.css') }}" rel="stylesheet">
</head>

<body>
    <div id="root"></div>
    <script src="{{ mix('src/main.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.js') }}" type="text/javascript"></script>
</body>

</html>
