@extends('layouts.admin.app')

@section('title', 'Usuarios')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Lista de Usuarios</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <a href="{{ route('users.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Usuario</a>
            </div>   
            <table id="table-users" class="table-condensed table-striped table-bordered table-hover table-condensed" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Fecha de Creacion</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@section('css')
@stop

@section('js')
    <script>
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
                    { data: 'created_at', name: 'created_at' },
                    { data: 'btn', orderable: false, searchable: false }   
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
    //swit alert
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        </script>
   @endif
@stop