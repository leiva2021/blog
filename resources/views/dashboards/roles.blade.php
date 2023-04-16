@extends('layouts.admin')

@section('content')

<!-- Start modal add rol -->
<div class="modal fade" id="RolModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="form_rol">
                @csrf
                <div class="modal-body p-4 bg-light">
                    <div class="my-2">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn_rol" class="btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal add rol  -->

<!-- Start modal edit rol -->
<div class="modal fade" id="EditRolModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="edit_form_rol">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-body p-4 bg-light">
                    <div class="my-2">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="edit_btn_rol" class="btn btn-primary">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal edit rol  -->


<div class="card mb-4 mt-5">
    <div class="card-header">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#RolModal"><i class="fas fa-add"></i>
            Nuevo Rol
        </button>
        <button class="btn btn-primary">Asignar rol</button>
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap" id="show_all_roles">
            <h3 class="text-center text-secondary my-5">Cargando...</h3>
        </div>
    </div>
</div>

<script>
    $(function() {

        $("#form_rol").submit(function(e) {

            e.preventDefault()
            const formData = new FormData(this)
            $("#btn_rol").text("Agregando...")
            $.ajax({
                url: "{{ route('role.store') }}",
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status === 200) {

                        toastr.success('Se registro correctamente!', 'Rol', {
                            timeOut: 2000,
                        })

                        fetchAllRoles()
                    }
                    $("#btn_rol").text('Agregar');
                    $("#form_rol")[0].reset();
                    $("#RolModal").modal('hide');
                }
            });

        });

        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault()
            let id = $(this).attr('id')

            $.ajax({
                url: "{{ route('role.edit') }}",
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    $(".modal-body").LoadingOverlay("hide");

                    $('#edit_form_rol input[name="id"]').val(response.id);
                    $('#edit_form_rol input[name="name"]').val(response.name);
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

        $("#edit_form_rol").submit(function(e) {
            e.preventDefault()
            const formData = new FormData(this)
            $("#edit_btn_rol").text('Editando...');
            $.ajax({
                url: "{{ route('role.update') }}",
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status === 200) {

                        toastr.success('Se edito correctamente!', 'Role', {
                            timeOut: 2000,
                        })
                        fetchAllRoles();
                    }
                    $("#edit_btn_rol").text('Editar');
                    $("#edit_form_rol")[0].reset();
                    $("#EditRolModal").modal('hide');
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
                        url: "{{ route('role.destroy') }}",
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {

                            if (response.status === 200) {

                                Swal.fire(
                                    'Eliminado!',
                                    'Se elimino exitosamente.',
                                    'success'
                                )
                                fetchAllRoles();
                            }
                        }
                    });
                }
            })
        });


        fetchAllRoles()

        function fetchAllRoles() {

            $.ajax({
                url: "{{ route('role.fetchAllRoles') }}",
                method: 'get',
                success: function(response) {
                    $("#show_all_roles").html(response);
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