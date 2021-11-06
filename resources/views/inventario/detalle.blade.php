{{--  --}}
@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Detalle de producto</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('inventario.index') }}">Inventario</a></li>
            <li class="breadcrumb-item active">Detalle de producto</li>
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
                <h3 class="card-title">Detalle de producto: <b>{{ $producto->nombre }}</b></h3>
            </div>
            <input type="hidden" name="registro" id="registro" value="{{ $producto->id }}">
            <div class="card-body">
               <table id="listar" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width:10%; text-align: center">No.</th>
                        <th>Tipo operación</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Precio promedio</th>
                        <th>Fecha de registro</th>
                      </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {

        var registro = $('#registro').val();

        if(registro > 0 && !isNaN(registro))
        {
            var data = {registro:registro};
            var params = new Array();
            params.push(data);
            listar(params);
        }
      });
    var  listar = function(params){
        var table = $("#listar").DataTable({
            "processing": true,
            "serverSide": true,
            "destroy":true,
            "ajax":{
            'url': '/inventario-detalle-producto/show',
            'type': 'GET',
            'data': {
                'buscar': params
            }
          },
          "dom":"<'row'<'col-sm-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>",
          "columns":[
              {'data': 'id',"visible":false},
              {'data': 'nombre',"orderable":false,"searchable":false},
              {'data': 'precio',"orderable":false,"searchable":false,"render":function(data, type, row, meta){
                    return '<span>Q. '+ row.precio +'</span>'
                }
              },
              {'data': 'cantidad',"orderable":false,"searchable":false,"class":'text-center'},
              {'data': 'precio_promedio',"orderable":false,"searchable":false,"render":function(data, type, row, meta){
                    return '<span>Q. '+ row.precio_promedio +'</span>'
                }
              },
              {'data': 'fecha',"orderable":false,"searchable":false,"class":'text-center'},
          ],
          "language": language_spanish,
          "order": [[ 0, "asc" ]]
        });
    }
</script>
@endsection
