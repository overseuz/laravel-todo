<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons-->
  <link href="{{ asset('/app/dist/img/logo.png') }}" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">


  <!-- Template Main CSS File -->
  <link href="{{ asset('app/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header-transparent">
    <div class="container">

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          @if (Route::has('login'))
            @auth
                <li><a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Главная</a></li>
            @else
                <li><a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Войти</a></li>

                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Регистрация</a></li>
                @endif
            @endauth
          @endif
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container">
      <h1>{{ config('app.name', 'Laravel') }}</h1>
      <h2>Приложение для планирования своих задач</h2>
    </div>
  </section><!-- End Hero Section -->

</body>

</html>