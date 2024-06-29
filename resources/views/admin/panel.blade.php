@extends('adminlte::page')

@section('title', 'Panel Administrativo')

@section('content_header')
    <h1>@lang('Dashboard')</h1>
@stop

@section('content')

@stop

@section('css')
    <style>
        .swal-custom-popup {
        background-color: #f0f8ea;
        border: 2px solid #4caf50;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .swal-custom-title {
        color: #4caf50;
        font-size: 24px;
        .swal-custom-content {
        color: #333;
        font-size: 16px;
        }
    </style>
@stop

@section('js')
    <script>
        Swal.fire({
        title: '¡Bienvenido!',
        text: 'Gracias por acceder al panel de administración.',
        icon: 'info',
        timer: 3000,
        showConfirmButton: false,
        customClass: {
            popup: 'swal-custom-popup',
            title: 'swal-custom-title',
            content: 'swal-custom-content'
        }
        });
    </script>
@stop