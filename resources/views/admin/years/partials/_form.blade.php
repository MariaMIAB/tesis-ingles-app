<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="name">Nombre del Año Escolar</label>
            <input id="name" name="name" type="text" placeholder="Ej. 2024-2025" class="form-control form-control-sm"
                value="{{ old('name', $year->name) }}" required autocomplete="name" />
            @error('name')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="start_date">Fecha de Inicio</label>
            <input id="start_date" name="start_date" type="date" class="form-control form-control-sm"
                value="{{ old('start_date', $year->start_date) }}" required />
            @error('start_date')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="end_date">Fecha de Fin</label>
            <input id="end_date" name="end_date" type="date" class="form-control form-control-sm"
                value="{{ old('end_date', $year->end_date) }}" required />
            @error('end_date')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>