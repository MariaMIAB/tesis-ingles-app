<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="topic_name">Nombre del Tema</label>
            <input id="topic_name" name="topic_name" type="text" placeholder="Ej. Introducción a la Física" class="form-control form-control-sm"
                value="{{ old('topic_name', $topic->topic_name ?? '') }}" required autocomplete="topic_name" />
            @error('topic_name')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="topic_description">Descripción del Tema</label>
            <input id="topic_description" name="topic_description" type="text" placeholder="Ej. Fundamentos básicos de la física" class="form-control form-control-sm"
                value="{{ old('topic_description', $topic->topic_description ?? '') }}" required />
            @error('topic_description')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="row">
            <div class="col-6 form-group">
                <label for="year_id">Año</label>
                <select id="year_id" name="year_id" class="custom-select form-control-sm" required>
                    <option value="">Selecciona un año</option>
                    @foreach($years as $year)
                        <option value="{{ $year->id }}" {{ (old('year_id') ?? $topic->semester->year->id ?? '') == $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
                @error('year_id')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="col-6 form-group">
                <label for="semester_id">Semestre</label>
                <select id="semester_id" name="semester_id" class="custom-select form-control-sm" required>
                    <option value="">Selecciona un semestre</option>
                </select>
                @error('semester_id')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
</div>
