@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Productos</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
            <li class="breadcrumb-item active">Editar</li>
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
                          <h3 class="card-title">Editar producto</h3>
                          <div class="card-tools">
                            <a href="{{ route('productos.index') }}" style="float:right;"><i class="far fa-times-circle fa-2x"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('productos', [$producto->id]) }}" method="POST" autocomplete="off">
                            <input name="_method" type="hidden" value="PUT">
                            @csrf
                            <div class="form-group">
                                <label for="">Nombre del producto</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ $producto->nombre }}">
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Categoría</label>
                                <select name="categoria" class="form-control @error('nombre') is-invalid @enderror">
                                    <option value="0">--Seleccione una opción--</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                            @if ($categoria->id == $producto->id)
                                                selected = "selected"
                                            @endif
                                            >{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Porcentaje de ganancia <small>(sin signos)</small></label>
                                <input type="text" class="form-control @error('porcentaje') is-invalid @enderror" name="porcentaje" value="{{ $producto->porcentaje_ganancia }}">
                                @error('porcentaje')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Stock minímo</label>
                                <input type="text" class="form-control @error('stock_minimo') is-invalid @enderror" name="stock_minimo" value="{{ $producto->stock_minimo }}">
                                @error('stock_minimo')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Descripción</label>
                                <textarea name="descripcion" class="form-control @error('stock_minimo') is-invalid @enderror">{{ $producto->descripcion }}</textarea>
                                @error('descripcion')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-grup">
                                <button class="btn btn-success float-right" type="submit">Editar</button>
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

