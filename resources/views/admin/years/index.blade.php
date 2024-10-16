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
                <a href="{{ route('years.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Nuevo Año Escolar</a>
            </div>   
            <table id="table-years" class="table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Año Escolar</th>
                        <th scope="col">Fecha de inicio</th>
                        <th scope="col">Fecha de finalisacion</th>
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
    <script src="{{ asset('js/datatable-language.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#table-years').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:'api/dbyears',
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'end_date', name: 'end_date' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'btn', orderable: false, searchable: false }
                ],
                language: datatableLanguage,
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