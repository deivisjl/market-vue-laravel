@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Aperturar caja</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Aperturar caja</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid row justify-content-center">
        <div class="card card-outline card-primary col-md-5">
            <div class="card-header">
                  <h3 class="card-title">Detalle de la apertura de caja</h3>
            </div>
            <div class="card-body">
                <form method="POST" autocomplete="off" action="{{ route('aperturar') }}">
                    @csrf
                    <div class="form-group">
                        <h5><reloj-component></reloj-component></h5>
                    </div>
                    <div class="form-group">
                        <label for="">Saldo inicial</label>
                        <input type="text" class="form-control @error('saldo') is-invalid @enderror" name="saldo" value="{{ old('saldo') }}">
                        @error('saldo')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-flat float-right">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
@endsection
