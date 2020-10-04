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
        @if(auth()->check())
            <div class="text-center p-4 position-absolute">
                <a href="/preview/{{$session_id}}/admin" class="d-block" target="_blank">
                    <button dir="rtl" class="btn btn-lg btn-light">
                        عرض لوحة التحكم
                    </button>
                </a>
            </div>
        @endif
        <game :session_id="{{$session_id}}"></game>
    </div>
    <footer style="border-top: #ccc 1px solid;position: absolute;
    width: 100%;
    bottom: 0;">
        <div class="text-center p-2">
            تم تطوير الموقع من قبل ( فادي حجازي ، شهد خندقجي )
        </div>
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
