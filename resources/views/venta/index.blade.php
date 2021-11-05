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
            <li class="breadcrumb-item active">Ventas</li>
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
                  <h3 class="card-title">Ventas</h3>
            </div>
            <div class="card-body">
               <table id="listar" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width:10%; text-align: center">No.</th>
                        <th>Cliente</th>
                        <th>Factura</th>
                        <th>Monto</th>
                        <th>Fecha de venta</th>
                        <th style="width:20%; text-align: center">Acción</th>
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
          listar();
      });
    var  listar = function(){
        var table = $("#listar").DataTable({
            "processing": true,
            "serverSide": true,
            "destroy":true,
            "ajax":{
            'url': '/ventas/show',
            'type': 'GET'
          },

          "columns":[
              {'data': 'id'},
              {'data': 'cliente'},
              {'data': 'no_factura'},
              {'data': 'monto', "render":function(data,type,row,meta){
                return '<span> Q. '+ data +'</span>'
                }
              },
              {'data': 'fecha'},
              {'defaultContent':'<a href="" class="detalle btn btn-info btn-sm btn-flat"  data-toggle="tooltip" data-placement="top" title="Detalle del registro"><i class="fas fa-pencil-alt"></i> Detalle</a>', "orderable":false}
          ],
          "language": language_spanish,
          "order": [[ 0, "asc" ]]
        });
        obtener_data_detalle("#listar tbody",table);
    }
    var obtener_data_detalle = function(tbody,table){
         $(tbody).on("click","a.detalle",function(e){
             e.preventDefault();

             var data = table.fnGetData($(this).parents("tr"));

            var id = data.id;
             //window.location.href = "/ventas/" + id + "/edit";
          });
      }
</script>
@endsection
