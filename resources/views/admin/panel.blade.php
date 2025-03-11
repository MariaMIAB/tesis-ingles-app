@extends('layouts.admin.app')

@section('title', 'Panel Administrativo')

@section('content_header')
    <div class="card bg-success">
        <div class="card-header">
            <h1 class="text-white font-weight-bold" style="border-bottom: 4px solid white;">
                Panel de Administración
            </h1>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <!-- Tarjetas Resumen -->
    @php
        $cards = [
            ['color' => 'primary', 'icon' => 'users', 'title' => 'Usuarios', 'count' => $totalUsers],
            ['color' => 'info', 'icon' => 'book', 'title' => 'Temas', 'count' => $totalTopics],
            ['color' => 'warning', 'icon' => 'eye', 'title' => 'Total Vistas', 'count' => $totalViews],
            ['color' => 'danger', 'icon' => 'heart', 'title' => 'Total Likes', 'count' => $totalLikes],
            ['color' => 'purple', 'icon' => 'file-alt', 'title' => 'Exámenes', 'count' => $totalExams],
            ['color' => 'teal', 'icon' => 'tasks', 'title' => 'Actividades', 'count' => $totalActivities],
        ];
    @endphp

    @foreach ($cards as $card)
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="card bg-{{ $card['color'] }} text-white shadow">
            <div class="card-body d-flex align-items-center justify-content-between">
                <i class="fas fa-{{ $card['icon'] }} fa-3x"></i>
                <div class="text-end">
                    <h5 class="card-title">{{ $card['title'] }}</h5>
                    <h3>{{ $card['count'] }}</h3>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Gráficos de estadísticas -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Temas con Más Vistas</div>
            <div class="card-body">
                <canvas id="viewsChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">Temas con Más Likes</div>
            <div class="card-body">
                <canvas id="likesChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico de semestres con filtros -->
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Datos por Semestre</span>
                <div>
                    <select id="typeFilter" class="form-control d-inline w-auto">
                        <option value="topics">Temas</option>
                        <option value="exams">Exámenes</option>
                        <option value="activities">Actividades</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="semesterChart"></canvas>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const viewsData = @json($mostViewedTopics);
    const likesData = @json($mostLikedTopics);
    const semesterData = @json($formattedSemesterData);

    // Gráfico de temas con más vistas
    new Chart(document.getElementById('viewsChart'), {
        type: 'pie',
        data: {
            labels: viewsData.map(topic => topic.topic_name),
            datasets: [{
                data: viewsData.map(topic => topic.views_count),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
            }]
        }
    });

    // Gráfico de temas con más likes
    new Chart(document.getElementById('likesChart'), {
        type: 'pie',
        data: {
            labels: likesData.map(topic => topic.topic_name),
            datasets: [{
                data: likesData.map(topic => topic.likes_count),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
            }]
        }
    });

    // Gráfico de semestres
    const ctx = document.getElementById('semesterChart').getContext('2d');
    let semesterChart;

    function updateChart(type) {
        const labels = semesterData.map(item => item.semester);
        const data = semesterData.map(item => item[type]);

        if (semesterChart) semesterChart.destroy();
        semesterChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: type.charAt(0).toUpperCase() + type.slice(1),
                    data: data,
                    backgroundColor: '#36A2EB'
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    }

    document.getElementById('typeFilter').addEventListener('change', () => updateChart(typeFilter.value));

    updateChart('topics');
</script>
@stop