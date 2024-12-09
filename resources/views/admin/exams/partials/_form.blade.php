<div class="row">
    <div class="col-6 form-group">
        <label for="title">Título del Examen</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="col-6 form-group">
        <label for="type">Tipo de Examen</label>
        <select class="form-control" id="type" name="type" required>
            <option value="true_false">Verdadero/Falso</option>
            <option value="short_answer">Respuesta Corta</option>
            <option value="multiple_choice">Selección Múltiple</option>
            <option value="varied">Variado</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="col-6 form-group">
        <label for="duration">Duración (minutos)</label>
        <input type="number" class="form-control" id="duration" name="duration" required>
    </div>
    <div class="col-6 form-group">
        <label for="topic_id">Tema</label>
        <select class="form-control" id="topic_id" name="topic_id" required>
            @foreach($topics as $topic)
                <option value="{{ $topic->id }}">{{ $topic->topic_name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="description">Descripción</label>
    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
</div>
<div class="form-group">
    <label for="visibility">Visible</label>
    <select class="form-control" id="visibility" name="visibility" required>
        <option value="1">Sí</option>
        <option value="0">No</option>
    </select>
</div>

