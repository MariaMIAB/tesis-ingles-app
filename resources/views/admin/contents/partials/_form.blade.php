<div> 
    <div class="col-6 form-group">
        <label for="title">Título del Contenido</label>
        <input id="title" name="title" type="text" placeholder="Ej. Introducción al Contenido" class="form-control form-control-sm"
            value="{{ old('title', $content->title ?? '') }}" required autocomplete="title" />
        @error('title')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="body">Cuerpo del Contenido</label>
        <textarea id="body" name="body" placeholder="Ej. Detalles sobre el contenido" class="form-control form-control-sm"
            required>{{ old('body', $content->body ?? '') }}</textarea>
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('body');
        </script>
        @error('body')
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div> 
        <div class="col-3 form-group">
            <label for="images" class="btn btn-primary btn-sm btn-block">
                <i class="fas fa-upload"></i> Cargar Imágenes
                <input type="file" name="images[]" id="images" multiple class="form-control-file d-none">
            </label>
            @error('images')
                <span class="invalid-feedback d-block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div id="preview" class="mt-3"></div>
    </div>
    <input type="hidden" name="topic_id" value="{{ $topic->id }}">
</div>
<script>
    document.getElementById('images').addEventListener('change', function(e) {
        let preview = document.getElementById('preview');
        preview.innerHTML = ''; // Limpiar vista previa anterior
        for (let i = 0; i < e.target.files.length; i++) {
            let file = e.target.files[i];
            let reader = new FileReader();
            reader.onload = function(event) {
                let img = document.createElement('img');
                img.src = event.target.result;
                img.className = 'img-thumbnail mb-2';
                img.style.maxWidth = '15%';
                img.style.height = 'auto';
                img.style.display = 'inline-block';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
</script>
