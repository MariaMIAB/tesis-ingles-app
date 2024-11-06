@extends('layouts.admin.app')
@section('title', 'Dashboard')
@section('content_header')
    <h1>Editar Tema</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('topics.update', $topic->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    @include('admin.topics.partials._form')
                    <br>
                </div>
                <div>
                    <a class="btn btn-secondary" href="{{ route('topics.index') }}">Atrás</a>
                    <button class="btn btn-success" type="submit">Actualizar</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const yearSelect = document.getElementById('year_id');
            const semesterSelect = document.getElementById('semester_id');
            
            // Set the default year and load the semesters
            const loadSemesters = function (yearId, selectedSemesterId = null) {
                if (yearId) {
                    fetch(`/api/years/${yearId}/semesters`)
                        .then(response => response.json())
                        .then(data => {
                            semesterSelect.innerHTML = '<option value="">Selecciona un semestre</option>';
                            if (data.length > 0) {
                                data.forEach(semester => {
                                    const option = document.createElement('option');
                                    option.value = semester.id;
                                    option.text = semester.name;
                                    if (selectedSemesterId && semester.id == selectedSemesterId) {
                                        option.selected = true;
                                    }
                                    semesterSelect.appendChild(option);
                                });
                            } else {
                                semesterSelect.innerHTML = '<option value="">No hay semestres disponibles</option>';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                } else {
                    semesterSelect.innerHTML = '<option value="">Selecciona un semestre</option>';
                }
            };
            
            // Load semesters on page load if a year is selected
            if (yearSelect.value) {
                loadSemesters(yearSelect.value, {{ $topic->semester_id }});
            }

            yearSelect.addEventListener('change', function () {
                loadSemesters(this.value);
            });
        });
    </script>
@stop
