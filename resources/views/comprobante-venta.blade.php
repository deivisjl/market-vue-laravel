<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprobante de venta</title>
    <style>
        .table-custom{
            width: 100%;
        }
        .table{
            width: 100%;
        }
        .text-center{
            text-align: center;
        }
        .table-bordered {
            border: 1px solid #000;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #000;
        }
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border: 1px solid #000;
        }
        .table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        .text-center{
                text-align: center;
        }
        .col-xs-12{
            width: 100%
        }
        .col-xs-6{
            width: 50%;
        }
        .col-xs-3{
            width: 33.33%;
        }
        .row{
            margin-right: -15px;
            margin-left: -15px;
        }
        .card-default{
            border-color: #ddd;
        }
        .card {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #00000026;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
            box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
        }

        .card-default>.card-header{
            color: #333;
            background-color: #f5f5f5;
            border-color: #ddd;
        }
        .card-header {
            padding: 7px 15px;
            border-bottom: 1px solid transparent;
            border-top-left-radius: 3px;
            border-top-right-radius: 3px;
        }
        .card-body {
            padding: 5px;
        }
        *, ::after, ::before {
            box-sizing: border-box;
        }

        .col-xs-12, .col-xs-6, .col-xs-3{
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }
        .col-xs-12, .col-xs-6{
            float: left;
        }
        .col-xs-3{
            float: right;
        }
        .row:before {
            display: table;
            content: " ";
        }
    </style>
</head>
<body>
    {{--  --}}
    <table style="width: 100%">
        <tbody>
            <tr>
                <td style="width: 60%">
                    <div class="card card-default">
                        <div class="card-header text-center">
                          <b>{{ Session::get('tienda')->nombre }}</b>
                        </div>
                        <div class="card-body">
                          <table style="width: 100%">
                              <tbody>
                                  <tr>
                                      <th>{{ Session::get('tienda')->nombre }}</th>
                                  </tr>
                                  <tr>
                                      <th>{{ Session::get('tienda')->direccion }}</th>
                                  </tr>
                                  <tr>
                                      <th>Tel.: {{ Session::get('tienda')->telefono }}</th>
                                  </tr>
                              </tbody>
                          </table>
                        </div>
                    </div>
                </td>
                {{--  --}}
                <td style="width: 40%">
                    <div class="card card-default">
                        <div class="card-header text-center">
                          <b>Factura</b>
                        </div>
                        <div class="card-body">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <th  style="text-align:left">Fecha</th>
                                        <td>{{ \Carbon\Carbon::parse($venta->fecha_factura)->format('d-m-Y')}}</td>
                                    </tr>
                                    <tr>
                                        <th  style="text-align:left">No.:</th>
                                        <td>{{ $venta->no_factura}}</td>
                                    </tr>
                                    <tr>
                                        <th  style="text-align:left">Tipo de pago:</th>
                                        <td>{{ $venta->forma_pago->nombre}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    {{--  --}}
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>
                    <div class="card card-default">
                        <div class="card-header text-center">
                          <b>Datos del cliente</b>
                        </div>
                        <div class="card-body">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <th style="text-align:left; width:16.6667%">NOMBRE:</th>
                                        <td>{{$venta->cliente->nombres}} {{$venta->cliente->apellidos}}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left; width:16.6667%">NIT:</th>
                                        <td>{{ $venta->cliente->nit }}</td>
                                    </tr>
                                    <tr>
                                        <th style="text-align:left; width:16.6667%">DIRECCIÓN:</th>
                                        <td>{{ $venta->cliente->direccion }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    {{--  --}}
    <table style="width: 100%">
        <tbody>
            <tr>
                <td>
                    <div class="card card-default">
                        <div class="card-header text-center">
                          <b>Detalle de Factura</b>
                        </div>
                        <div class="card-body">
                            <table style="width: 100%; text-align:left">
                                <thead>
                                    <tr>
                                        <th style="text-align: left">Cantidad</th>
                                        <th style="text-align: left">Producto</th>
                                        <th style="text-align: left">Precio Unitario</th>
                                        <th style="text-align: left">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($venta->detalle_venta as $item)
                                        <tr>
                                            <td>{{ $item->cantidad }}</td>
                                            <td>{{ $item->producto->nombre }}</td>
                                            <td>Q. {{ $item->precio_unitario }}</td>
                                            <td>Q. {{ number_format(($item->precio_unitario * $item->cantidad ),2)}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    {{--  --}}
    {{--  --}}
    <div class="row">
        <div class="col-xs-3">
            <div class="card card-default">
                <div class="card-header text-center">
                  <b>Total</b>
                </div>
                <div class="card-body">
                    <table style="width: 100%; text-align:center">
                        <tbody>
                            <tr>
                                <td>Q. {{$venta->monto}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
