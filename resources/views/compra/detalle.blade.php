@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Compras</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('compras.index') }}">Compras</a></li>
            <li class="breadcrumb-item active">Detalle compras</li>
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
                        <h3 class="card-title">Detalle compra</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Proveedor</th>
                                            <td>{{ $compra->proveedor->nombre }}</td>
                                        </tr>
                                        <tr>
                                            <th>Número de comprobante</th>
                                            <td>{{ $compra->no_comprobante }}</td>
                                        </tr>
                                        <tr>
                                            <th>Monto de compra</th>
                                            <td>Q. {{ $compra->monto }}</td>
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
                                        @foreach ($compra->detalle_compra as $key => $item)
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
