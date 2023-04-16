@extends('layouts.admin')

@section('css')
    <style>
        .image-wrapper {
            position: relative;
            padding-bottom: 56.25%;
        }

        .image-wrapper img {
            position: absolute;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>

@endsection

@section('content')

<div class="card mt-3">
    <div class="card-header">
        <h5>Formulario de editar post</h5>
    </div>
    <div class="card-body">
        <form action="#" id="edit-form-post" method="POST" enctype="multipart/form-data">

            @csrf

            <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" id="temp_image" name="temp_image" value="{{ $post->url }}">
            <input type="hidden" id="postid" name="postid" value="{{ $post->id }}">

            <div class="form-group">
                <label for="title">T&iacute;tulo:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" placeholder="Ingrese el t&iacute;tulo del post" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="slug">Slug:</label>
                <input type="text" id="slug" value="{{ $post->slug }}" class="form-control" name="slug" placeholder="Ingrese el slug del post" readonly>
            </div>
            <div class="form-group">
                <label for="category_id">Categor&iacute;a:</label>
                <select class="form-select" name="category_id" id="category_id" required>
                    <option disabled selected>Seleccione categor&iacute;a</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="content">Contenido:</label>
                <textarea class="form-control" name="content" id="content" cols="30" rows="10">{{ $post->content }}</textarea>
            </div>

            <div id="load">
            </div>

            <div class="row mb-2">
                <div class="col">
                    <div class="image-wrapper">
                        @if(isset($post->url))
                        <img id="picture" class="img-thumbnail" src=" {{ asset("storage/{$post->url}") }}" alt="imagen del post">
                        @else
                        <img id="picture" class="img-thumbnail" src=" http://2.bp.blogspot.com/-A7oFEnqNCDA/VCmRSJYj2AI/AAAAAAACUeA/_lCx_Nj3b7g/s1600/fotos%2Bde%2Bpaisajes%2Bnaturales%2B(3).jpg" alt="imagen del post">
                        @endif
                    </div>
                </div>
                <div class="col">
                    <div class="form-group mb-2">
                        <label for="file"><strong>Subir imagen del post:</strong></label>
                        <input type="file" accept="image/*" class="form-control" id="file" name="file">
                    </div>
                    <p>La imagen debe ir acorde a su post para que tenga m&aacute;s sentido.</p>
                </div>
            </div>

            <button type="submit" id="edit-post" class="btn btn-success">Editar Post</button>
        </form>
    </div>
</div>

@endsection

@section('js')

<script src="{{asset('storage/assets/stringToSlug/speakingurl.min.js')}}"></script>
<script src="{{asset('storage/assets/stringToSlug/jquery.stringtoslug.min.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });

    $(function() {

        $("#title").stringToSlug({
            setEvents: 'keyup keydown blur',
            getPut: '#slug',
            space: '-'
        });

        $("#file").change(function(e) {

            var file = e.target.files[0];
            var reader = new FileReader();
            reader.onload = (event) => {
                $("#picture").attr('src', event.target.result)
            };
            reader.readAsDataURL(file)
        });

        $("#edit-form-post").submit(function(e) {
            e.preventDefault();
            const formData = new FormData(this)
            $("#edit-post").text("Editando...")
            $.ajax({
                url: "{{ route('post.update') }}",
                method: 'post',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {

                    if (response.status == 200) {

                        $("#load").LoadingOverlay("hide");

                        toastr.success('Se editó correctamente!', 'Post', {
                            timeOut: 2000,
                        })
                    }
                    $("#edit-post").text('Editar Post');
                    $("#form-post")[0].reset();
                },
                beforeSend: function() {

                    $("#load").LoadingOverlay("show", {
                        imageResizeFactor: 2,
                        text: "Editando...",
                        size: 20
                    });
                },
            });
        });

    });
</script>

@endsection