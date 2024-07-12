@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    @include('admin.users.partials._form')
                    <br>
                </div>
                <div>
                    <a class="btn btn-secondary" href="{{ route('home') }}">Ya registrado?</a>
                    <button class="btn btn-success" type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </div>
@stop

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
    </style>
@stop

@section('js')

@stop