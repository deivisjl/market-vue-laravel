@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Reportes</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Reportes</li>
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
                  <h3 class="card-title">Reporte gráfico</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Productos más vendidos</h3>
                            </div>
                            <div class="card-body">
                                <mas-vendidos-component></mas-vendidos-component>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Productos próximos a agotarse</h3>
                            </div>
                            <div class="card-body">
                                <productos-proximo-agotarse-component></productos-proximo-agotarse-component>
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
@section('js')
<script>
    $(document).ready(function(){
        if(!$('body').hasClass("sidebar-collapse")){
            $('body').addClass("sidebar-collapse");
        }
    })
</script>
@endsection
