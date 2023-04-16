@extends('layouts.admin')

@section('content')

<!-- Start modal add user -->
<div class="modal fade" id="UserModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="form_user">
                @csrf
                <div class="modal-body p-4 bg-light">

                    <div class="my-2">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre" required>
                    </div>

                    <div class="my-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el email" required>
                    </div>

                    <div class="my-2">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la contraseña">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn_user" class="btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal add user  -->

<!-- Start modal edit user -->
<div class="modal fade" id="EditUserModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="edit_form_user">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-body p-4 bg-light">

                    <div class="my-2">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre" required>
                    </div>

                    <div class="my-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el email" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" id="edit_btn_user" class="btn btn-primary">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal edit user  -->


<div class="card mb-4 mt-5">
    <div class="card-header">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#UserModal">
            <i class="fas fa-add"></i>
            Nuevo Usuario
        </button>
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap" id="show_all_users">
            <h3 class="text-center text-secondary my-5">Cargando...</h3>
        </div>
    </div>
</div>

<script>
    $(function() {


        $("#form_user").submit(function(e) {

            e.preventDefault()
            const formData = new FormData(this)
            $("#btn_user").text("Agregando...")

            $.ajax({
                url: "{{ route('user.store') }}",
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status == 200) {

                        toastr.success('Se registro correctamente!', 'Usuario', {
                            timeOut: 2000,
                        })

                        fetchAllUsers()
                    }
                    $("#btn_user").text('Agregar');
                    $("#form_user")[0].reset();
                    $("#UserModal").modal('hide');
                }
            });

        });

        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault()
            let id = $(this).attr('id')

            $.ajax({
                url: "{{ route('user.edit') }}",
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    $(".modal-body").LoadingOverlay("hide");

                    $('#edit_form_user input[name="id"]').val(response.id);
                    $('#edit_form_user input[name="name"]').val(response.name);
                    $('#edit_form_user input[name="email"]').val(response.email);

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

        $("#edit_form_user").submit(function(e) {
            e.preventDefault()
            const formData = new FormData(this)
            $("#edit_btn_user").text('Editando...');
            $.ajax({
                url: "{{ route('user.update') }}",
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status === 200) {

                        toastr.success('Se edito correctamente!', 'Usuario', {
                            timeOut: 2000,
                        })
                        fetchAllUsers();
                    }
                    $("#edit_btn_user").text('Editar');
                    $("#edit_form_user")[0].reset();
                    $("#EditUserModal").modal('hide');
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
                        url: "{{ route('user.destroy') }}",
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
                                fetchAllUsers();
                            }
                        }
                    });
                }
            })
        });

        fetchAllUsers()

        function fetchAllUsers() {

            $.ajax({
                url: "{{ route('user.fetchAllUsers') }}",
                method: 'get',
                success: function(response) {
                    $("#show_all_users").html(response);
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