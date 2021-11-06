@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Mi perfil</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Mi perfil</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row mb-2 justify-content-center">
            <div class="col-sm-10">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                          <h3 class="card-title">Mi perfil</h3>
                          <div class="card-tools">
                            <a href="{{ route('home') }}" style="float:right;"><i class="far fa-times-circle fa-2x"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                              <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Datos personales</a>
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Contraseña</a>
                              </div>
                            </div>
                            <div class="col-9">
                              <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    {{--  --}}
                                    <form action="{{ route('usuarios.perfil')}}" method="POST" autocomplete="off">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Nombres</label>
                                            <input type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres" value="{{ Auth::user()->nombres }}">
                                            @error('nombres')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Apellidos</label>
                                            <input type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos" value="{{ Auth::user()->apellidos }}">
                                            @error('apellidos')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Teléfono</label>
                                            <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ Auth::user()->telefono }}">
                                            @error('telefono')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Dirección</label>
                                            <textarea name="direccion" class="form-control @error('nombre') is-invalid @enderror">{{ Auth::user()->direccion }}</textarea>
                                            @error('direccion')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-grup">
                                            <button class="btn btn-info btn-flat float-right" type="submit">Actualizar</button>
                                        </div>
                                    </form>
                                    {{--  --}}
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    {{--  --}}
                                    <form action="{{ route('usuarios.pass')}}" method="POST" autocomplete="off">
                                        @csrf
                                        <div class="form-group">
                                            <label for="">Nueva contraseña</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="">Repetir contraseña</label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-grup">
                                            <button class="btn btn-info btn-flat float-right" type="submit">Guardar</button>
                                        </div>
                                    </form>
                                    {{--  --}}
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
@endsection

