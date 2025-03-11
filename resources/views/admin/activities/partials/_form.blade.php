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

        <!-- Selector para tipo de actividad -->
        <div class="form-group">
            <label for="activity_type">Tipo de Actividad</label>
            <select id="activity_type" class="custom-select">
                <option value="h5p" selected>Enlace H5P</option>
                <option value="scorm">Subir SCORM</option>
            </select>
        </div>

        <!-- Campo para enlace H5P (visible por defecto) -->
        <div class="form-group" id="h5p_container">
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

        <!-- Campo para subir SCORM (oculto por defecto) -->
        <div class="form-group" id="scorm_container" style="display: none;">
            <label for="scorm_file">Subir SCORM (ZIP)</label>
            <input type="file" class="form-control form-control-sm" name="scorm_file" id="scorm_file" accept=".zip">
            @error('scorm_file')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Columna derecha -->
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

<!-- Script para alternar entre H5P y SCORM -->
<script>
    document.getElementById("activity_type").addEventListener("change", function () {
        let type = this.value;
        document.getElementById("h5p_container").style.display = (type === "h5p") ? "block" : "none";
        document.getElementById("scorm_container").style.display = (type === "scorm") ? "block" : "none";
        document.getElementById("link").required = (type === "h5p");
        document.getElementById("scorm_file").required = (type === "scorm");
    });
</script>

