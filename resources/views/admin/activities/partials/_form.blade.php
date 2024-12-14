<div class="row">
    <!-- Columna izquierda -->
    <div class="col-6">
        <div class="form-group">
            <label for="title">Título</label>
            <input id="title" name="title" type="text" placeholder="Título de la actividad" class="form-control form-control-sm"
                value="{{ old('title', $activity->title ?? '') }}" required autocomplete="title" />
            @error('title')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Descripción</label>
            <textarea id="description" name="description" placeholder="Descripción de la actividad" class="form-control form-control-sm"
                required>{{ old('description', $activity->description ?? '') }}</textarea>
            @error('description')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="link">Enlace H5P</label>
            <input id="link" name="link" type="url" placeholder="https://h5p.org/content/..." class="form-control form-control-sm"
                value="{{ old('link', $activity->link ?? '') }}" required />
                <br>
            <a href="https://h5p.org/" class="btn-h5p" target="_blank">Ir a H5P</a>
            @error('link')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="topic_id">Tema</label>
            <select name="topic_id" id="topic_id" class="custom-select" required>
                @foreach ($topics as $topic)
                    <option value="{{ $topic->id }}" {{ old('topic_id', $activity->topic_id ?? '') == $topic->id ? 'selected' : '' }}>
                        {{ $topic->topic_name }}
                    </option>
                @endforeach
            </select>
        </div>        
        <div class="form-group">
            <label for="status">Estado</label>
            <input type="checkbox" id="status" name="status" class="mr-2" value="1" {{ old('status', $activity->status ?? 1) ? 'checked' : '' }}>
            Activar
        </div>
    </div>
</div>
