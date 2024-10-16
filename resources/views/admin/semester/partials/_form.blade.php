<div class="row">
    <!-- Primer Semestre -->
    <div class="col-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Primer Semestre</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="semester1_start_date">Fecha de Inicio del Primer Semestre</label>
                    <input id="semester1_start_date" name="semesters[0][start_date]" type="date" class="form-control form-control-sm"
                        value="{{ old('semesters.0.start_date', $year->start_date ?? '') }}" />
                    @error('semesters.0.start_date')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="semester1_end_date">Fecha de Fin del Primer Semestre</label>
                    <input id="semester1_end_date" name="semesters[0][end_date]" type="date" class="form-control form-control-sm"
                        value="{{ old('semesters.0.end_date' , $semesters[0]->end_date ?? '') }}" />
                    @error('semesters.0.end_date')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Segundo Semestre -->
    <div class="col-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Segundo Semestre</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="semester2_start_date">Fecha de Inicio del Segundo Semestre</label>
                    <input id="semester2_start_date" name="semesters[1][start_date]" type="date" class="form-control form-control-sm"
                        value="{{ old('semesters.1.start_date', $semesters[1]->start_date ?? '') }}" />
                    @error('semesters.1.start_date')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="semester2_end_date">Fecha de Fin del Segundo Semestre</label>
                    <input id="semester2_end_date" name="semesters[1][end_date]" type="date" class="form-control form-control-sm"
                        value="{{ old('semesters.1.end_date', $semesters[1]->end_date ?? '') }}" />
                    @error('semesters.1.end_date')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Tercer Semestre -->
    <div class="col-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Tercer Semestre</h5>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="semester3_start_date">Fecha de Inicio del Tercer Semestre</label>
                    <input id="semester3_start_date" name="semesters[2][start_date]" type="date" class="form-control form-control-sm"
                        value="{{ old('semesters.2.start_date', $semesters[2]->start_date ?? '') }}" />
                    @error('semesters.2.start_date')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="semester3_end_date">Fecha de Fin del Tercer Semestre</label>
                    <input id="semester3_end_date" name="semesters[2][end_date]" type="date" class="form-control form-control-sm"
                        value="{{ old('semesters.2.end_date', $year->end_date ?? '') }}" />
                    @error('semesters.2.end_date')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="year_id" value="{{ $year->id }}">