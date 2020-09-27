<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #e0e0e0;
            font-family: 'Almarai', sans-serif;
        }
    </style>
</head>
<body>
    <div id="app">
        <game :questions="{{$questions}}"></game>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
