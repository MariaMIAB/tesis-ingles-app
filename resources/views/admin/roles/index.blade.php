@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
<div class="card bg-success">
    <div class="card-header">
        <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Gestion de Roles y Permisos</h1>
    </div>
</div>
@stop

@section('content')
    <h3 class="text-green font-weight-bold">Por Roles</h3>
    <div class="card">
        <div class="card-body">
            <table id="table-roles" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('css')
    <style>
        .list-group-item {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            margin-bottom: 5px;
            padding: 0.5rem;
            transition: transform 0.2s, background-color 0.2s;
        }

        .list-group-item:hover {
            transform: scale(1.05);
            background-color: #e9ecef;
        }

        .list-group-item .badge {
            font-size: 0.85rem;
            padding: 0.3em 0.6em;
        }

        .list-group-item span {
            font-weight: bold;
            margin-left: 5px;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('js/datatable-language.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#table-roles').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'api/dbroles',
                columns : [
                    { data: 'id' , name:'id' },
                    { data: 'name', name: 'name'},
                    { data: 'btn', orderable: false, searchable: false }   
                ],
                language: datatableLanguage,
            });
        });
    </script>
@stop
