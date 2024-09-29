<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0"/>
    <title>SHOP</title>
    @vite(['resources/css/app.css','resources/css/materialize.css','resources/js/app.js','resources/js/materialize.js','resources/js/init.js'])
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/SHOP.png') }}" type="image/x-icon" />
</head>
<body>

    @yield('content')

<script src="{{ asset('js/vue.js') }}"></script>
<script src="{{ asset('js/vue-router.js') }}"></script>
<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/axios.js') }}"></script>
@yield('scripts')
</body>
</html>