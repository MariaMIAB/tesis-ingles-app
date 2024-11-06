@extends('layouts.admin.app')

@section('title', 'Tema')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Lista de Contenidos del tema {{ $topic->topic_name }}</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div>
                <a href="{{ route('contents.create', ['topic_id' => $topic->id]) }}" class="btn btn-success"><i class="fas fa-plus"></i> Contenido</a>
            </div>
            <table id="table-contents" class="table-striped table-bordered table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Titulo</th>
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
            let topicId = {{ $topic->id }};
    
            $('#table-contents').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/api/dbcontents/' + topicId,
                    error: function(xhr, status, error) {
                        console.error("Error in DataTables AJAX request: ", error);
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
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
