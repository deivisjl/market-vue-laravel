<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="hold-transition login-page text-sm">
<div id="app" class="login-box">
  <!-- /.login-logo -->
  <div class="card card-widget widget-user">
    <!-- Add the bg color to the header using any of the bg-* classes -->
    <div class="widget-user-header text-white" style="background: url('/img/supermarket.png') center center no-repeat;">
      <h3 class="widget-user-username text-right">{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</h3>
      <h5 class="widget-user-desc text-right">{{ Auth::user()->rol->nombre }}</h5>
    </div>
    <div class="card-header">
        <h3 class="card-title">Selecciona una tienda</h3>
        <div class="card-tools">
          <i class="fas fa-lock"></i>
        </div>
        <!-- /.card-tools -->
      </div>
      <div class="card-body p-0">
        <ul class="nav nav-pills flex-column">
            @foreach ($tiendas as $item)
            <li class="nav-item active">
                <form action="{{ route('elegir-tienda') }}" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="tienda" value="{{ $item->id }}">
                    <button class="btn btn-block" type="submit">
                        <div class="float-left text-primary"><i class="fas fa-store"></i> {{ $item->nombre }}</div>
                        <span class="float-right"><i class="fas fa-arrow-right"></i></span>
                    </button>
                </form>
              </li>
            @endforeach
          </ul>
    </div>
  </div>
  {{--  --}}
</div>
<!-- /.login-box -->

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
