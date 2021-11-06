@extends('layouts.app')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Inicio</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item active">{{ Session::get('tienda')->nombre }}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                      <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('img/profile.png') }}" alt="User profile picture">
                      </div>

                      <h3 class="profile-username text-center">{{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}</h3>

                      <p class="text-muted text-center">{{ Auth::user()->rol->nombre }}</p>

                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                          <b>Correo electrónico</b> <a class="float-right">{{ Auth::user()->email }}</a>
                        </li>
                        <li class="list-group-item">
                          <b>Teléfono</b> <a class="float-right">{{ Auth::user()->telefono }}</a>
                        </li>
                      </ul>

                      <a href="/mi-perfil" class="btn btn-primary btn-block"><b>Actualizar perfil</b></a>
                    </div>
                    <!-- /.card-body -->
                  </div>
            </div>
        </div>
    </div>
  </section>
  <!-- /.content -->
@endsection
