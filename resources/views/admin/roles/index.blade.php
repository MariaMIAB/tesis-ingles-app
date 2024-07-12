@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
<div class="card bg-success">
    <div class="card-header">
        <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Lista de Roles</h1>
    </div>
</div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <table id="table-roles" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
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
        $('#table-roles').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'api/dbroles',
                columns : [
                    { data: 'id' , name:'id' },
                    { data: 'name', name: 'name'},
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