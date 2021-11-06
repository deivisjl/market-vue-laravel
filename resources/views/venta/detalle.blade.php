@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Ventas</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('ventas.index') }}">Ventas</a></li>
            <li class="breadcrumb-item active">Detalle venta</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Detalle venta</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Cliente</th>
                                            <td>{{ $venta->cliente->nombres }} {{ $venta->cliente->apellidos }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. Factura</th>
                                            <td>{{ $venta->no_factura }}</td>
                                        </tr>
                                        <tr>
                                            <th>Monto de venta</th>
                                            <td>Q. {{ $venta->monto }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:10%; text-align: center">No.</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio unitario</th>
                                        </tr>
                                        </thead>
                                        @foreach ($venta->detalle_venta as $key => $item)
                                            <tr>
                                                <td style="text-align:center">{{ $key + 1 }}</td>
                                                <td>{{ $item->producto->nombre }}</td>
                                                <td>{{ $item->cantidad }}</td>
                                                <td>Q. {{ $item->precio_unitario }}</td>
                                            </tr>
                                        @endforeach
                                </table>
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
