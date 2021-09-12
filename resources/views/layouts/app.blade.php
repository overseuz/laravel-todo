<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('/app/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/app/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
  <!-- Datatable -->
  <link rel="stylesheet" href="{{ asset('/app/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
  <!-- SweetAlert -->
  <link rel="stylesheet" href="{{ asset('/app/plugins/sweetalert2/sweetalert2.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('/app/plugins/toastr/toastr.min.css') }}">
  <!-- TagsInput -->
  <link rel="stylesheet" href="{{ asset('/app/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

  <link rel="shortcut icon" href="{{ asset('/app/dist/img/logo.png') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('/app/dist/img/logo.png') }}" alt="Vyatsu Logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand navbar-dark fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-none d-md-none d-lg-block">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="brand-link pt-2 pl-0 text-light">
          <img src="{{ asset('/app/dist/img/logo.png') }}" alt="{{ config('app.name', 'Laravel') }} - Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
        </a>
      </li>
      <li class="nav-item pt-1">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
    
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="top: 56px;">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open menu-is-opening">
            <a href="" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
              <p>
                Главная
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Перейти на главную</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item menu-open menu-is-opening">
            <a href="" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
              <p>
                Списки задач
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @yield('task-lists')
              <li class="nav-header text-uppercase">Настройки</li>
              <li class="nav-item">
                <a href="{{ route('task_lists.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Управление списками</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-white" style="padding-top: 80px;">
      @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer navbar-dark">
    {{ config('app.name', 'Laravel') }}, {{ date('Y') }}
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('/app/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/app/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="{{ asset('/app/plugins/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('/app/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/app/dist/js/adminlte.js') }}"></script>

<!-- DataTable -->
<script src="{{ asset('/app/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/app/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- SweetALert -->
<script src="{{ asset('/app/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Toastr -->
<script src="{{ asset('/app/plugins/toastr/toastr.min.js') }}"></script>

<!-- TagsInput -->
<script src="{{ asset('/app/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>


@stack('scripts')

</body>
</html>