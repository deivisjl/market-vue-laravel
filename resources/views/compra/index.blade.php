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
            <li class="breadcrumb-item active">Compras</li>
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
                          <h3 class="card-title">Compra de productos</h3>
                          <div class="card-tools">
                              <a href="{{ route('compras.create') }}" class="btn btn-primary btn-xs btn-flat" style="float:right; color:#fff">Nuevo registro</a>
                          </div>
                    </div>
                    <div class="card-body">
                       <table id="listar" class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th style="width:10%; text-align: center">No.</th>
                                <th>Proveedor</th>
                                <th>No. comprobante</th>
                                <th>Forma de pago</th>
                                <th>Monto</th>
                                <th>Fecha de registro</th>
                                <th style="width:20%; text-align: center">Acción</th>
                              </tr>
                            </thead>
                        </table>
                    </div>
                </div>
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
            'url': '/compras/show',
            'type': 'GET'
          },

          "columns":[
              {'data': 'id'},
              {'data': 'proveedor'},
              {'data': 'no_comprobante'},
              {'data': 'forma_pago'},
              {'data': 'monto', "render":function(data,type,row,meta){
                return '<span> Q. '+ data +'</span>'
                }
              },
              {'data': 'fecha',"orderable":false, "searchable":false},
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
             window.location.href = "/compras-detalle/" + id;
          });
      }
</script>
@endsection
