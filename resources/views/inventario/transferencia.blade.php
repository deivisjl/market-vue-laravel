{{--  --}}
@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Transferencia de stock</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Transferencia</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Transferir productos</h3>
                <div class="card-tools">
                    <a href="{{ route('home') }}" style="float:right;"><i class="far fa-times-circle fa-2x"></i></a>
                </div>
            </div>
            <div class="card-body">
                <transferencia-component :registro="{{ $tienda }}"></transferencia-component>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
@endsection
