@extends('layouts.admin.app')

@section('title', 'Actividades')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Lista de Actividades</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <a href="{{ route('activities.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Nueva Actividad</a>
            </div>
            <table id="table-activities" class="table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Título</th>
                        <th scope="col">Tema</th>
                        <th scope="col">Fecha de Creación</th>
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
            $('#table-activities').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/api/dbactivities',
                    error: function(xhr, status, error) {
                        console.error("Error in DataTables AJAX request: ", error);
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'topic_name', name: 'topic.name' }, // Columna para el nombre del tema
                    { data: 'created_at', name: 'created_at' },
                    { data: 'btn', name: 'btn', orderable: false, searchable: false }
                ],
                language: datatableLanguage,
            });
        });
    </script>
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
