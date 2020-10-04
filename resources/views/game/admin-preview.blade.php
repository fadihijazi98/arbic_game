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
    <header style="height: 100px; background-color: #0665d0" class="py-5 text-right text-white">
        <div class="bg-header-dark" style="padding-right: 50px">
            <div class="content-header bg-white-10 text-center">
                <h3>قائمة الأسئلة</h3>
            </div>
        </div>

    </header>
    <main style="margin-top: 70px; margin-right: 50px">
        <admin :session_id="{{$session_id}}"></admin>
    </main>
    <footer style="border-top: #ccc 1px solid;position: absolute;
    width: 100%;
    bottom: 0;">
                <div class="text-center p-2">
                    تم تطوير الموقع من قبل ( فادي حجازي ، شهد خندقجي )
                </div>
    </footer>
</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
