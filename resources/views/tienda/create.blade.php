@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tiendas</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tiendas.index') }}">Tiendas</a></li>
            <li class="breadcrumb-item active">Nuevo</li>
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
                          <h3 class="card-title">Nueva tienda</h3>
                          <div class="card-tools">
                            <a href="{{ route('tiendas.index') }}" style="float:right;"><i class="far fa-times-circle fa-2x"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('tiendas.store') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label for="">Nombre de la tienda</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}">
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">C??digo de facturaci??n <small>(Iniciales)</small></label>
                                <input type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ old('codigo') }}">
                                @error('codigo')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Nombre del gerente</label>
                                <input type="text" class="form-control @error('gerente') is-invalid @enderror" name="gerente" value="{{ old('gerente') }}">
                                @error('gerente')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Tel??fono</label>
                                <input type="numeric" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}">
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Direcci??n</label>
                                <textarea name="direccion" class="form-control @error('direccion') is-invalid @enderror">{{ old('direccion') }}</textarea>
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

