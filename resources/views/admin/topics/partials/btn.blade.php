<div class="text-center d-flex justify-content-around">
    <a href="{{ route('topics.show', $id) }}" class="btn btn-info btn-sm mr-2"><i class="fa fa-eye"></i></a>
    <a href="{{ route('topics.edit', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
    <form action="{{ route('topics.destroy', $id) }}" method="POST" style="display: inline" class="formulario-eliminar">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
    </form>
</div>

<script>
    $('.formulario-eliminar').submit(function(e) {
        e.preventDefault();
        console.log('Formulario de eliminación enviado');
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¡No podrás revertir esto!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, bórralo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Confirmado');
                this.submit();
            }
        });
    });
</script>


