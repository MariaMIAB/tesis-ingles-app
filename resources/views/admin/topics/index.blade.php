@extends('layouts.admin.app')

@section('title', 'Temas')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Lista de Temas</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <a href="{{ route('topics.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Tema</a>
            </div>
            <table id="table-topics" class="table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre del Tema</th>
                        <th scope="col">Semestre</th>
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
            $('#table-topics').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:'api/dbtopics',
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'topic_name', name: 'topic_name' },
                    { data: 'semester.name', name: 'semester.name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'btn', orderable: false, searchable: false }
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
