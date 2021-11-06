@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Usuario</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">Nuevo usuario</li>
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
            <div class="col-sm-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                          <h3 class="card-title">Nuevo usuario</h3>
                          <div class="card-tools">
                            <a href="{{ route('usuarios.index') }}" style="float:right;"><i class="far fa-times-circle fa-2x"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('usuarios.store')}}" method="POST" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label for="">Nombres</label>
                                <input type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres" value="{{ old('nombres') }}">
                                @error('nombres')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Apellidos</label>
                                <input type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos" value="{{ old('apellidos') }}">
                                @error('apellidos')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Rol</label>
                                <select name="rol" id="" class="form-control @error('apellidos') is-invalid @enderror">
                                    <option value="0">--Seleccione una opción--</option>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol->id }}"
                                            @if ($rol->id == old('rol'))
                                                selected="selected"
                                            @endif
                                            >{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('apellidos')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Teléfono</label>
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}">
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Dirección</label>
                                <textarea name="direccion" class="form-control @error('nombre') is-invalid @enderror">{{ old('direccion') }}</textarea>
                                @error('direccion')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Correo electrónico</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Contraseña</label>
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
                            <div class="form-group">
                                <label for="">Acceso a tiendas</label>
                                <ul class="todo-list">
                                    @foreach ($tiendas as $item)
                                        <li>
                                            <div class="icheck-primary d-inline ml-2">
                                                <input type="checkbox" name="tienda[]" value="{{ $item->id }}" id="tienda-{{ $item->id }}">
                                                <label for="tienda-{{ $item->id }}"></label>
                                            </div>
                                            <span class="text">{{ $item->nombre }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                @error('direccion')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-grup">
                                <button class="btn btn-primary float-right" type="submit">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
@endsection

