@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Permisos Rol</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('roles.update', $role) }}">
                @csrf
                @method('PUT')
        
                <div class="row">
                    <div class="col-md-6">
                        <h4>Permisos Relacionados</h4>
                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div id="related-permissions" class="permission-list">
                                    @foreach ($allPermissions as $permission)
                                        @if ($rolePermissions->contains($permission))
                                            <div class="form-check permission-item related">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $permission->id }}"
                                                    id="permission{{ $permission->id }}"
                                                    checked
                                                    style="display: none;"
                                                >
                                                <label class="form-check-label" for="permission{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removePermission({{ $permission->id }})">-</button>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4>Permisos No Relacionados</h4>
                        <hr>
                        <div class="card">
                            <div class="card-body">
                                <div id="unrelated-permissions" class="permission-list">
                                    @foreach ($allPermissions as $permission)
                                        @if (!$rolePermissions->contains($permission))
                                            <div class="form-check permission-item unrelated">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $permission->id }}"
                                                    id="permission{{ $permission->id }}"
                                                    style="display: none;"
                                                >
                                                <label class="form-check-label" for="permission{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                                <button type="button" class="btn btn-success btn-sm" onclick="addPermission({{ $permission->id }})">+</button>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="mt-3">
                    <button class="btn btn-success" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
<style>
    .img-highlight {
        border: 2px solid #10c245;
        border-radius: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .img-highlight:hover {
        transform: scale(1.1);
        box-shadow: 0 0 10px #10c245;
    }
    .form-control {
        border-radius: 5px;
        transition: border-color 0.2s ease;
    }

    .form-control:hover {
        border-color: #0cb93a;
    }
    .permission-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .permission-item {
        position: relative;
        padding: 5px;
        border: 1px solid #ccc;
        margin-bottom: 5px;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
        font-size: 0.9em;
    }

    .permission-item.related:hover {
        background-color: #ff6666;
        color: white;
        font-weight: bold;
    }

    .permission-item.unrelated:hover {
        background-color: #66cc66;
        color: white;
        font-weight: bold;
    }

    .permission-item button {
        display: none;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
    }

    .permission-item:hover button {
        display: inline-block;
    }
</style>
@stop

@section('js')
    <script>
        function removePermission(permissionId) {
            const permissionElement = document.getElementById('permission' + permissionId).parentElement;
            document.getElementById('unrelated-permissions').appendChild(permissionElement);
            permissionElement.querySelector('input').checked = false;
            permissionElement.classList.remove('related');
            permissionElement.classList.add('unrelated');
            permissionElement.querySelector('button').classList.remove('btn-danger');
            permissionElement.querySelector('button').classList.add('btn-success');
            permissionElement.querySelector('button').innerText = '+';
            permissionElement.querySelector('button').setAttribute('onclick', 'addPermission(' + permissionId + ')');
        }

        function addPermission(permissionId) {
            const permissionElement = document.getElementById('permission' + permissionId).parentElement;
            document.getElementById('related-permissions').appendChild(permissionElement);
            permissionElement.querySelector('input').checked = true;
            permissionElement.classList.remove('unrelated');
            permissionElement.classList.add('related');
            permissionElement.querySelector('button').classList.remove('btn-success');
            permissionElement.querySelector('button').classList.add('btn-danger');
            permissionElement.querySelector('button').innerText = '-';
            permissionElement.querySelector('button').setAttribute('onclick', 'removePermission(' + permissionId + ')');
        }
    </script>
@stop