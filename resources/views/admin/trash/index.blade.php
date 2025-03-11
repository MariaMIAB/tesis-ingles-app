@extends('layouts.admin.app')

@section('title', 'Papelera')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Papelera</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h3>Usuarios Eliminados</h3>
            <table id="trash-users" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trashedUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <form action="{{ route('users.restore', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success" style="margin-right: 5px;"><i class="fas fa-undo"></i></button>
                                    </form>
                                    <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h3>Temas Eliminados</h3>
            <table id="trash-topics" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trashedTopics as $topic)
                        <tr>
                            <td>{{ $topic->id }}</td>
                            <td>{{ $topic->topic_name }}</td>
                            <td>{{ $topic->topic_description }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <form action="{{ route('topics.restore', $topic->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success" style="margin-right: 5px;"><i class="fas fa-undo"></i></button>
                                    </form>
                                    <form action="{{ route('topics.forceDelete', $topic->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h3>Contenidos Eliminados</h3>
            <table id="trash-contents" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Cuerpo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trashedContents as $content)
                        <tr>
                            <td>{{ $content->id }}</td>
                            <td>{{ $content->title }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($content->body, 50) }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <form action="{{ route('contents.restore', $content->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success" style="margin-right: 5px;"><i class="fas fa-undo"></i></button>
                                    </form>
                                    <form action="{{ route('contents.forceDelete', $content->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h3>Actividades Eliminadas</h3>
            <table id="trash-activities" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trashedActivities as $activity)
                        <tr>
                            <td>{{ $activity->id }}</td>
                            <td>{{ $activity->title }}</td>
                            <td>{{ $activity->description }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <form action="{{ route('activities.restore', $activity->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success" style="margin-right: 5px;"><i class="fas fa-undo"></i></button>
                                    </form>
                                    <form action="{{ route('activities.forceDelete', $activity->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .btn-group .btn {
            padding: 5px 10px;
            border-radius: 5px;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('js/datatable-language.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#trash-users').DataTable({
                language: datatableLanguage
            });
            $('#trash-topics').DataTable({
                language: datatableLanguage
            });
            $('#trash-contents').DataTable({
                language: datatableLanguage
            });
            $('#trash-activities').DataTable({
                language: datatableLanguage
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