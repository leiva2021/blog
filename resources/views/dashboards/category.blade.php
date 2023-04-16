@extends('layouts.admin')

@section('content')


<!-- Modal Add Category -->
<div class="modal fade" id="CategoryModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Categor&iacute;a</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="form_category">
                @csrf
                <div class="modal-body p-4 bg-light">

                    <div class="my-2">
                        <label for="title">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la categor&iacute;a" required>
                    </div>

                    <div class="my-2">
                        <label for="editorial">Slug</label>
                        <input type="type" class="form-control" id="slug" name="slug" placeholder="Slug" readonly>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn_category" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End modal add category -->

<!-- Modal Edit Category -->
<div class="modal fade" id="editCategoryModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Categor&iacute;a</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="edit_category_form">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-body p-4 bg-light">
                    <div class="my-2">
                        <label for="name">Categor&iacute;a</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nombre de la categor&iacute;a" required>
                    </div>
                    <div class="my-2">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" id="slug" class="form-control" placeholder="slug" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="edit_category_btn" class="btn btn-primary">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal edit Category -->

<div class="card mb-4 mt-5">
    <div class="card-header">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#CategoryModal">
            <i class="fas fa-add"></i>
            Nueva Categor&iacute;a
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap" id="show_all_categories">
            <h3 class="text-center text-secondary my-5">Cargando...</h3>
        </div>
    </div>
</div>

<!-- Migrar el script a un archivo externo -->
<script>
    function slugify(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-') // Reemplazar espacios con guiones
            .replace(/[^\w\-]+/g, '') // Eliminar caracteres no alfanuméricos
            .replace(/\-\-+/g, '-') // Eliminar guiones consecutivos
            .replace(/^-+/, '') // Eliminar guiones iniciales
            .replace(/-+$/, ''); // Eliminar guiones finales
    }

    $(function() {

        // ? Hay que optimizar
        $('#name').on('keyup', function() {
            var name = $(this).val();
            var slug = slugify(name);
            $('#slug').val(slug);
        });

        $('#edit_category_form input[name="name"]').on('keyup', function() {
            var name = $(this).val();
            var slug = slugify(name);
            $('#edit_category_form input[name="slug"]').val(slug);
        });

        $("#form_category").submit(function(e) {
            e.preventDefault()
            const formData = new FormData(this)

            $("#btn_category").text("Agregando...")
            $.ajax({
                url: "{{ route('category.store') }}",
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status == 200) {

                        toastr.success('Se registro correctamente!', 'Categoria', {
                            timeOut: 2000,
                        })

                        fetchAllCategories()
                    }
                    $("#btn_category").text('Enviar');
                    $("#form_category")[0].reset();
                    $("#CategoryModal").modal('hide');
                }
            });

        });

        // edit category ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();

            let id = $(this).attr('id')
            $.ajax({
                url: "{{ route('category.edit') }}",
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    $(".modal-body").LoadingOverlay("hide");

                    $('#edit_category_form input[name="id"]').val(response.id);
                    $('#edit_category_form input[name="name"]').val(response.name);
                    $('#edit_category_form input[name="slug"]').val(response.slug);

                },
                beforeSend: function() {

                    $(".modal-body").LoadingOverlay("show", {
                        imageResizeFactor: 2,
                        text: "Consultando...",
                        size: 14
                    });
                },
            });
        });

        $("#edit_category_form").submit(function(e) {
            e.preventDefault()
            const formData = new FormData(this)
            $("#edit_category_btn").text('Editando...');
            $.ajax({
                url: "{{ route('category.update') }}",
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status === 200) {

                        toastr.success('Se edito correctamente!', 'Categoria', {
                            timeOut: 2000,
                        })

                        fetchAllCategories();
                    }
                    $("#edit_category_btn").text('Editar');
                    $("#edit_category_form")[0].reset();
                    $("#editCategoryModal").modal('hide');
                }
            });
        });

        $(document).on('click', '.deleteIcon', function(e) {
            e.preventDefault()
            let id = $(this).attr('id')
            let csrf = '{{ csrf_token() }}';
            Swal.fire({
                title: 'Estas seguro?',
                text: "Deseas eliminarlo!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('category.destroy') }}",
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {

                            if (response.status == 200) {

                                Swal.fire(
                                    'Eliminado!',
                                    'Se elimino exitosamente.',
                                    'success'
                                )
                                fetchAllCategories();
                            }
                        }
                    });
                }
            })

        });

        fetchAllCategories()

        function fetchAllCategories() {

            $.ajax({
                url: "{{ route('category.getAllCategories') }}",
                method: 'get',
                success: function(response) {
                    $("#show_all_categories").html(response);
                    $("#datatablesSimple").DataTable({
                        "responsive": true,
                        order: [0, 'asc'],
                        "language": {
                            "url": "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"
                        }
                    });
                }
            });
        }
    });
</script>

@endsection