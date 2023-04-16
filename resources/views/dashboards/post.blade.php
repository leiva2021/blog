@extends('layouts.admin')

@section('content')

<header>
    <h1 class="text-center">Lista de Posts</h1>
</header>

<div class="card mb-4 mt-5">
    <div class="card-header">
        <a class="btn btn-success" href="{{ route('post.create') }}">Nuevo post</a>
    </div>

    <div class="card-body">
        <div class="table-responsive text-nowrap" id="show_all_posts">
            <h3 class="text-center text-secondary my-5">Cargando...</h3>
        </div>
    </div>
</div>


<script>
    $(function() {

        fetchAllPost()

        function fetchAllPost() {

            $.ajax({
                url: "{{ route('post.getFetchAllPosts') }}",
                method: 'get',
                success: function(response) {
                    $("#show_all_posts").html(response);
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