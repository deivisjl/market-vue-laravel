@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tiendas</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active">Tiendas</li>
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
                  <h3 class="card-title">Tiendas</h3>
                  <div class="card-tools">
                      <a href="{{ route('tiendas.create') }}" class="btn btn-primary btn-xs btn-flat" style="float:right; color:#fff">Nuevo registro</a>
                  </div>
            </div>
            <div class="card-body">
               <table id="listar" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width:10%; text-align: center">No.</th>
                        <th>Nombre</th>
                        <th>Gerente</th>
                        <th>Teléfono</th>
                        <th>Estatus</th>
                        <th></th>
                        <th >Acción</th>
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
            'url': '/tiendas/show',
            'type': 'GET'
          },

          "columns":[
              {'data': 'id'},
              {'data': 'nombre'},
              {'data': 'gerente'},
              {'data': 'telefono'},
              {'data': 'status', "render":function(data,type,row,meta){
                    if(row.status >= 1)
                    {
                        return '<span class="badge badge-success">Activo</span>'
                    }
                    else
                    {
                        return '<span class="badge badge-warning">Inactivo</span>'
                    }
                }
              },
              {'data':'status', "render":function(data, type,row,meta){
                    if(row.status >= 1)
                    {
                        return '<a href="" class="deshabilitar btn btn-info btn-sm btn-flat"  data-toggle="tooltip" data-placement="top" title="Deshabilitar registro"><i class="fas fa-pen-square"></i> Deshabilitar</a>';
                    }
                    else
                    {
                        return '<a href="" class="deshabilitar btn btn-default btn-sm btn-flat"  data-toggle="tooltip" data-placement="top" title="Habilitar registro"><i class="fas fa-pen-square"></i> Habilitar</a>';
                    }
                }
              },
              {'defaultContent':'<a href="" class="editar btn btn-success btn-sm btn-flat"  data-toggle="tooltip" data-placement="top" title="Editar registro"><i class="fas fa-pencil-alt"></i> Editar</a> <a href="" class="borrar btn btn-danger btn-sm btn-flat"  data-toggle="tooltip" data-placement="top" title="Borrar registro"><i class="fas fa-trash-alt"></i> Eliminar</a>', "orderable":false}
          ],
          "language": language_spanish,
          "order": [[ 0, "asc" ]]
        });
        obtener_data_editar("#listar tbody",table);
    }
    var obtener_data_editar = function(tbody,table){
        $(tbody).on("click","a.deshabilitar",function(e){
             e.preventDefault();

             var data = table.fnGetData($(this).parents("tr"));

            var id = data.id;

            axios.get('/tiendas-deshabilitar/'+id)
                          .then(response => {
                              Toastr.success(response.data.data,'Mensaje')
                              table._fnAjaxUpdate() //actualizar datatable

                          })
                          .catch(error => {
                              if (error.response) {
                                  Toastr.error(error.response.data.error,'');
                              }else{
                                  Toastr.error('Ocurrió un error: ' + error,'Error');
                              }
                          });
          });
         $(tbody).on("click","a.editar",function(e){
             e.preventDefault();

             var data = table.fnGetData($(this).parents("tr"));

            var id = data.id;
             window.location.href = "/tiendas/" + id + "/edit";
          });
         $(tbody).on("click","a.borrar",function(e){
             e.preventDefault();
             var data = table.fnGetData($(this).parents("tr"));

            var id = data.id;
             Swal.fire({
                  title: '¿Está seguro de eliminar este registro?',
                  //text: 'Confirmar',
                  icon:'warning',
                  type: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Aceptar',
                  cancelButtonText: 'Cancelar'
                }).then((result) => {
                   if (result.value) {
                      axios.delete('/tiendas/'+id)
                          .then(response => {
                              Toastr.success(response.data.data,'Mensaje')
                              table._fnAjaxUpdate() //actualizar datatable

                          })
                          .catch(error => {
                              if (error.response) {
                                  Toastr.error(error.response.data.error,'');
                              }else{
                                  Toastr.error('Ocurrió un error: ' + error,'Error');
                              }
                          });
                   }

                });

          });
      }
</script>
@endsection
