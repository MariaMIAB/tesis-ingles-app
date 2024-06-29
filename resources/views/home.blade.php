@extends('layouts.app')

@section('content')
    <div class="course-container cardboard">
        <div class="course-text">
            <h3>Presentación</h3>
            <hr>
            <p>¡Bienvenidos a mi curso virtual! Mi nombre es Maria Isabel Alvarez Barriga y seré su instructor/a durante estas próximas semanas/meses. Tengo 23 años de experiencia en inglés y estoy muy emocionado/a de compartir mi conocimiento con ustedes.</p>
            <h3>Propósito del curso</h3>
            <hr>
            <p>Este curso ha sido diseñado para enseñarles inglés de manera efectiva y práctica. Durante este tiempo, trabajaremos juntos para que puedan adquirir las habilidades y conocimientos necesarios para tener éxito en este campo.</p>
            <h3>Expectativas</h3>
            <hr>
            <p>Espero que dediquen tiempo y esfuerzo a este curso para poder aprovecharlo al máximo. Les pediré que completen [cantidad] de tareas, que participen activamente en las discusiones y que estén comprometidos con su propio aprendizaje.</p>
            <h3>Comunicación</h3>
            <hr>
            <p>La comunicación es clave en cualquier curso, por lo que estaré disponible para responder cualquier pregunta que puedan tener. Pueden comunicarse conmigo a través de [correo electrónico, plataforma de aprendizaje, etc.] y les enviaré información sobre el curso a través de [correo electrónico, plataforma de aprendizaje, etc.].</p>
        </div>
        <div class="course-image">
            <img src="storage/imagenes/sistema/ingles.png" alt="Imagen del curso">
        </div>
    </div>
@endsection

@section('css')
<style>
    .course-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px;
        margin: 40px; /* Agrega un margen al contenedor */
    }
    .course-text {
        flex: 1;
        padding-right: 20px;
    }
    .course-image img {
        max-width: 100%;
        height: auto;
    }
    .cardboard {
        background-color: #8cf594;
        border: 1px solid #ccc;
        padding: 30px;
        border-radius: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    h1, h2, h3 {
        font-weight: bold; /* Grosor en negrita */
    }
    p {
        font-weight: normal;
        font-size: 18px;
        line-height: 1.5; 
    }
    hr {
        border: none;
        height: 2px;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
</style>
@endsection

