@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center p-5">
        <div class="col-md-6">
            <img src="{{ asset('img/404.png') }}" alt="" style="width: 100%">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-2">
            <a href="/" class="btn btn-primary btn-lg btn-block">Ir al inicio</a>
        </div>
    </div>
</div>
@endsection
