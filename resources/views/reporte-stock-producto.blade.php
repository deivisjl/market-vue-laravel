<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de stock por producto</title>
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
    </style>
</head>
<body>
    <table class="table-custom">
        <tr style="text-align: center">
            <td>Reporte de stock por producto</td>
        </tr>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th></th>
                <th>Tienda</th>
                <th>Producto</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @if(sizeof($registros) > 0)
                @foreach ($registros as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->tienda }}</td>
                        <td>{{ $item->producto }}</td>
                        <td class="text-center">{{ $item->stock }}</td>
                    </tr>
                @endforeach
            @else
            <tr style="text-align:center">
                <td colspan="4">No se encontraron registros</td>
            </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
