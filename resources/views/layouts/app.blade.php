<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'WearMe Dashboard') }}</title>
  <!-- Favicon -->
  <link href="{{ asset('argon') }}/img/brand/logo.jpeg" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <style>

  .tdBorderSimple{
    border-top:1px solid #000 !important;
    border-left:1px solid #000 !important;
    text-align: center !important;
  }

  .tdBorderBottom{
    border-bottom: 1px solid #000 !important;
  }

  .tdBorderRight{
    border-right: 1px solid #000 !important;
  }

  .bottomBorder{
    border: 1px solid #000;
    width:100%;
    margin:0px !important;
    padding:0px !important;
  }

  .bottomtds td,.bottomtds th{
    border: 1px solid #000;
  }
  .collapseLink{
    padding-left:25px;
  }

  .printTime{
    width: 100% !important;
    margin: 0px !important;
    padding: 0px !important; 
  }

  </style>
  @yield('head-content')
</head>
<body class="{{ $class ?? '' }}">
  @auth()
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  @include('layouts.navbars.sidebar')
  @endauth

  <div class="main-content">
    @include('layouts.navbars.navbar')
    @yield('content')
  </div>

  @guest()
  @include('layouts.footers.guest')
  @endguest

  <!-- <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script> -->
  <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  @stack('js')

  <!-- Argon JS -->
  <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>


</body>
</html>
