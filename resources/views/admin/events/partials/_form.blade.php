<div class="form-group">
    <label for="title">Título del Evento</label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $event->title) }}" required>
    @error('title')
    <span class="invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
<div class="form-group">
    <label for="description">Descripción</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6">{{ old('description', $event->description) }}</textarea>
    @error('description')
    <span class="invalid-feedback d-block" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>                         
<div class="row">
    <div class="col-6 form-group">
        <label for="start">Fecha de Inicio</label>
        <input type="datetime-local" name="start" class="form-control @error('start') is-invalid @enderror" value="{{ old('start', $event->start ? \Carbon\Carbon::parse($event->start)->format('Y-m-d\TH:i') : '') }}" required>
        @error('start')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>
    <div class="col-6 form-group">
        <label for="end">Fecha de Fin</label>
        <input type="datetime-local" name="end" class="form-control @error('end') is-invalid @enderror" value="{{ old('end', $event->end ? \Carbon\Carbon::parse($event->end)->format('Y-m-d\TH:i') : '') }}" required>
        @error('end')
        <span class="invalid-feedback d-block" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

