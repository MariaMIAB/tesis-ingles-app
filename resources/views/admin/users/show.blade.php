@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">Detalles de Usuario</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row d-flex align-items-center">
                <div class="col-6">
                    @if ($user->hasMedia('avatar'))
                    <img src="{{ url($ava) }}" alt="Avatar del usuario" width="200" class="img-fluid rounded-circle shadow border border-success mt-3 mb-3">
                    @else
                    <img src="{{ asset('storage/imagenes/sistema/user.png') }}" alt="Avatar por defecto" width="120" class="img-fluid rounded-circle shadow border border-success mt-3 mb-3">
                    @endif                      
                    <p><strong>Nombre:</strong> {{ $user->name }}</p>
                    @if ($user->roles->isNotEmpty())
                        <p><strong>Rol:</strong> {{ $user->roles->first()->name }}</p>
                    @else
                        <p><strong>No tiene Rol</strong></p>
                    @endif
                </div>
                <div class="col-6"> 
                    <p><strong>Correo electrónico:</strong> {{ $user->email }}</p>
                    <p><strong>Verificado:</strong> {{ $user->email_verified_at ?: 'No se ha verificado' }}</p>
                    <p><strong>Creado el:</strong> {{ $user->created_at }}</p>
                    <p><strong>Actualizado el:</strong> {{ $user->updated_at }}</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop