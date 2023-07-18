<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  {{-- <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}"> --}}
   <!-- Theme style -->
   <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
   <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
   <link rel="stylesheet" href="{{asset('css/skins/_all-skins.min.css')}}">
 
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
  <link rel="stylesheet" href="{{asset('jquery.dataTables.min.css')}}">

  
  @vite(['resources/sass/app.scss', 'resources/js/app.js']);
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div id="app">
<div class="wrapper mt-0">

  <!-- Preloader -->
  {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div> --}}

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light pt-0 mt-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
   

    
      <!-- Notifications Dropdown Menu -->
      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <form action="/logout" method="post">
          @csrf
          <button class="nav-link" role="button">
            {{-- <i class="fas fa-power-off"></i> --}}
            cerrar sesion
          </button>
        </form>
      </li>
      
     
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/inicio" class="brand-link">
      {{-- <img src="{{asset('img/logo.png')}}" alt="AdminLTE Logo" class="brand-image  elevation-3" style="height:250px important!;"> --}}
      
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('img/avatar4.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>

     

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          @if(DB::table('formulario')
              ->join('usuario_formulario', 'usuario_formulario.id_formulario', '=', 'formulario.id')
              ->join('rol', 'usuario_formulario.id_rol', '=', 'rol.id')
              ->join('users', 'users.id_rol', '=', 'rol.id')
              ->where('users.id_rol', '=', auth()->user()->id_rol)
              ->where('formulario.nombre', '=', 'usuario')
              ->count()>0 || DB::table('formulario')
              ->join('usuario_formulario', 'usuario_formulario.id_formulario', '=', 'formulario.id')
              ->join('rol', 'usuario_formulario.id_rol', '=', 'rol.id')
              ->join('users', 'users.id_rol', '=', 'rol.id')
              ->where('users.id_rol', '=', auth()->user()->id_rol)
              ->where('formulario.nombre', '=', 'rol')
              ->count()>0)
              
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>
                    Usuarios
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>

                <ul class="nav nav-treeview">
                  @if(DB::table('formulario')
                  ->join('usuario_formulario', 'usuario_formulario.id_formulario', '=', 'formulario.id')
                  ->join('rol', 'usuario_formulario.id_rol', '=', 'rol.id')
                  ->join('users', 'users.id_rol', '=', 'rol.id')
                  ->where('users.id_rol', '=', auth()->user()->id_rol)
                  ->where('formulario.nombre', '=', 'usuario')
                  ->count()>0)
                    <li class="nav-item">
                      <a href="/usuarios/index" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Usuarios</p>
                      </a>
                    </li>
                  @endif
                </ul>
                <ul class="nav nav-treeview">
                  @if(DB::table('formulario')
                  ->join('usuario_formulario', 'usuario_formulario.id_formulario', '=', 'formulario.id')
                  ->join('rol', 'usuario_formulario.id_rol', '=', 'rol.id')
                  ->join('users', 'users.id_rol', '=', 'rol.id')
                  ->where('users.id_rol', '=', auth()->user()->id_rol)
                  ->where('formulario.nombre', '=', 'rol')
                  ->count()>0)
                    <li class="nav-item">
                      <a href="/roles/index" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Roles</p>
                      </a>
                    </li>
                  @endif
                  </ul>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-chart-pie"></i>
                  <p>
                    Gestion Docentes
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="/docente" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Docente</p>
                      </a>
                    </li>
                </ul>
                <ul class="nav nav-treeview">
                  
                    <li class="nav-item">
                      <a href="/especialidad" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Especialidades</p>
                      </a>
                    </li>

                </ul>

                <ul class="nav nav-treeview">
                  
                  <li class="nav-item">
                    <a href="/curso" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Cursos</p>
                    </a>
                  </li>

                </ul>
                <ul class="nav nav-treeview">
                  
                  <li class="nav-item">
                    <a href="/experiencia" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Experiencias</p>
                    </a>
                  </li>

              </ul>
              </li>
            @endif

          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- /.content-header -->

    