<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm">
    <div id="app">
          <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-light sticky-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link"><reloj-component></reloj-component></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> --}}

      <!-- Messages Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> --}}
      <!-- Notifications Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> --}}
      {{-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li> --}}
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('cambiar-tienda') }}" role="button">
            <i class="fas fa-exchange-alt"></i> Cambiar tienda
        </a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="/logout" role="button">
            <i class="fas fa-power-off"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link p-2 mb-1">
      <h4 class="text-center">{{ Session::get('tienda')->nombre }}</h4>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-2 pb-2 mb-2 d-flex">
        <div class="image">
          <img src="{{ asset('img/market.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="/mi-perfil" class="d-block">{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}
              <small><i class="fa fa-circle user-status-dot d-block" style="color: #6ec95e;"> {{ Auth::user()->rol->nombre }}</i></small>
          </a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            @if(Auth::user()->esGerente() || Auth::user()->esAdministrador())
            <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Catálogos
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('categorias.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Categorías</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('proveedores.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Proveedores</p>
                    </a>
                  </li>
                  {{-- <li class="nav-item">
                    <a href="{{ route('unidades-de-medida.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Unidad de medida</p>
                    </a>
                  </li> --}}
                  <li class="nav-item">
                    <a href="{{ route('formas-de-pago.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Forma de pago</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('productos.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Productos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('clientes.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Clientes</p>
                    </a>
                  </li>
                </ul>
            </li>
            @endif
            @if(Auth::user()->esGerente() || Auth::user()->esAdministrador())
            <li class="nav-item">
                <a href="{{ route('tiendas.index') }}" class="nav-link">
                  <i class="nav-icon fas fa-store"></i>
                  <p>
                    Tiendas
                  </p>
                </a>
              </li>
              @endif
              @if(Auth::user()->esVendedor() || Auth::user()->esAdministrador() || Auth::user()->esGerente())
              <li class="nav-item">
                <a href="{{ route('ventas.create') }}" class="nav-link">
                  <i class="nav-icon fas fa-money-bill-alt"></i>
                  <p>
                    Punto de venta
                  </p>
                </a>
              </li>
              @endif
            @if(Auth::user()->esGerente() || Auth::user()->esAdministrador())
            <li class="nav-item">
                <a href="{{ route('compras.index') }}" class="nav-link">
                <i class="nav-icon fas fa-truck-loading"></i>
                <p>
                    Compras
                </p>
                </a>
            </li>
            @endif
          {{--  --}}
          @if(Auth::user()->esGerente() || Auth::user()->esAdministrador())
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Inventario
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('inventario.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Existencias de productos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('transferencia') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Transferencia de stock</p>
                </a>
              </li>
            </ul>
        </li>
        @endif
          {{--  --}}
          @if(Auth::user()->esGerente() || Auth::user()->esAdministrador())
          <li class="nav-item">
            <a href="{{ route('ventas.index') }}" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Ventas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('usuarios.index') }}" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->esGerente())
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Reportes
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/reportes-graficos" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reporte gráfico</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/reportes-pdf" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reportes PDF</p>
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
        @yield('content')
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Mini Market &copy; 2021 </strong>
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1
    </div>
  </footer>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>
</html>
