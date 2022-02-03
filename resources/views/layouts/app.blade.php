<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>在庫管理アプリ</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/for_create_item.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.11.19/xlsx.full.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/image/zaiko_icon.png">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=IM+Fell+DW+Pica+SC" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Caveat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Economica:700" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Homemade+Apple rel="stylesheet">

    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=IM+Fell+DW+Pica+SC" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=IM+Fell+DW+Pica+SC" rel="stylesheet">
    
    <link href="{{ asset('css/share/common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/common.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/user.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/item.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/cart.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/notification.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/thema.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/history.css') }}" rel="stylesheet">
    <link href="{{ asset('css/item/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/item/create.css') }}" rel="stylesheet">
    <link href="{{ asset('css/item/show.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user/login.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user/register.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user/show.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user/edit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cart/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cart/confirm.css') }}" rel="stylesheet">
</head>
<body>
<div>
    <div id="app">
        <root-component></root-component>
    </div>
</body>
</html>
