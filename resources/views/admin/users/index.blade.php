@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Lista de Usuarios</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <table id="table-users" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Fecha de Creacion</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

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
        //swal.fire
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
        //tabla
        $(document).ready(function(){
        $('#table-users').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'api/dbusers',
                columns : [
                    { data: 'id' , name:'id' },
                    { data: 'name', name: 'name'},
                    { data: 'email', name: 'email'},
                    { data: 'created_at', name: 'created_at' }
                ],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": ">>",
                        "previous": "<<"
                    }
                },
            });
        });
    </script>
@stop