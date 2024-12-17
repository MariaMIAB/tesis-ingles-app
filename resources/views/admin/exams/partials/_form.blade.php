<div class="row">
    <!-- Título del Examen -->
    <div class="col-8 form-group">
        <label for="title">Título del Examen</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $exam->title ?? '') }}" required>
    </div>

    <!-- Tipo de Examen -->
    <div class="col-4 form-group">
        <label for="type">Tipo de Examen</label>
        <select class="form-control" id="type" name="type" required>
            <option value="true_false" {{ old('type', $exam->type ?? '') == 'true_false' ? 'selected' : '' }}>Verdadero/Falso</option>
            <option value="short_answer" {{ old('type', $exam->type ?? '') == 'short_answer' ? 'selected' : '' }}>Respuesta Corta</option>
            <option value="multiple_choice" {{ old('type', $exam->type ?? '') == 'multiple_choice' ? 'selected' : '' }}>Selección Múltiple</option>
            <option value="varied" {{ old('type', $exam->type ?? '') == 'varied' ? 'selected' : '' }}>Variado</option>
        </select>
    </div>
</div>

<div class="row">
    <!-- Selector de Año -->
    <div class="col-3 form-group">
        <label for="year_id">Año</label>
        <select class="form-control" id="year_id" name="year_id" required>
            <option value="" disabled {{ !isset($exam) ? 'selected' : '' }}>Selecciona un año</option>
            @foreach($years as $year)
                <option value="{{ $year->id }}" {{ old('year_id', $exam->year_id ?? '') == $year->id ? 'selected' : '' }}>
                    {{ $year->name }} ({{ $year->start_date }} - {{ $year->end_date }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- Selector de Semestre -->
    <div class="col-3 form-group">
        <label for="semester_id">Semestre</label>
        <select class="form-control" id="semester_id" name="semester_id" required>
            <option value="" disabled selected>Selecciona un semestre</option>
            @if(isset($semesters))
                @foreach($semesters as $semester)
                    <option value="{{ $semester->id }}" {{ old('semester_id', $exam->semester_id ?? '') == $semester->id ? 'selected' : '' }}>
                        {{ $semester->name }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    <!-- Duración del Examen -->
    <div class="col-3 form-group">
        <label for="duration">Duración (minutos)</label>
        <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration', $exam->duration ?? '') }}" max="60" required>
    </div>

    <!-- Tema -->
    <div class="col-3 form-group">
        <label for="topic_id">Tema</label>
        <select class="form-control" id="topic_id" name="topic_id" required>
            <option value="" disabled selected>Selecciona un tema</option>
            @foreach($topics as $topic)
                <option value="{{ $topic->id }}" {{ old('topic_id', $exam->topic_id ?? '') == $topic->id ? 'selected' : '' }}>
                    {{ $topic->topic_name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<!-- Descripción del Examen -->
<div class="form-group">
    <label for="description">Descripción</label>
    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $exam->description ?? '') }}</textarea>
</div>

<!-- Visibilidad -->
<div class="form-group">
    <label for="visibility">Visible</label>
    <select class="form-control" id="visibility" name="visibility" required>
        <option value="1" {{ old('visibility', $exam->visibility ?? '') == '1' ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ old('visibility', $exam->visibility ?? '') == '0' ? 'selected' : '' }}>No</option>
    </select>
</div>

<!-- Fecha de Publicación -->
<div class="form-group">
    <label for="published_at">Fecha de Publicación</label>
    <input type="datetime-local" class="form-control" id="published_at" name="published_at" 
    value="{{ old('published_at', isset($exam) && $exam->published_at ? $exam->published_at->format('Y-m-d\TH:i') : '') }}">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const yearSelect = document.getElementById('year_id');
        const semesterSelect = document.getElementById('semester_id');
        const selectedSemester = "{{ old('semester_id', $exam->semester_id ?? '') }}";
    
        function loadSemesters(selectedYear) {
            semesterSelect.innerHTML = '<option value="" disabled selected>Selecciona un semestre</option>';
    
            if (selectedYear) {
                fetch(`/api/years/${selectedYear}/semesters`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(semester => {
                            const option = document.createElement('option');
                            option.value = semester.id;
                            option.textContent = semester.name;
    
                            if (semester.id == selectedSemester) {
                                option.selected = true;
                            }
                            semesterSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error al cargar los semestres:', error));
            }
        }
    
        // Cargar semestres si ya hay un año seleccionado (en edición)
        if (yearSelect.value) {
            loadSemesters(yearSelect.value);
        }
    
        yearSelect.addEventListener('change', function () {
            loadSemesters(yearSelect.value);
        });
    });
</script>
    