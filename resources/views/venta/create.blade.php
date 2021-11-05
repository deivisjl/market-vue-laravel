@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0" style="display: inline-block;">Registrar venta <a href="{{ route('cerrar') }}" class="btn btn-danger" style="display: inline-block;"><i class="far fa-times-circle"></i> Cerrar caja</a></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></a></li>
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
        <venta-component></venta-component>
    </div>
  </section>
  <!-- /.content -->
@endsection
@section('js')
<script>
    $(document).ready(function(){
        if(!$('body').hasClass("sidebar-collapse")){
            $('body').addClass("sidebar-collapse");
        }
    })
</script>
@endsection

