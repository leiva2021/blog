@extends('layouts.public')

<style>
    .post-content {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        /* número de líneas a mostrar */
        -webkit-box-orient: vertical;
    }
</style>

@section('content')
<div class="container px-4 px-lg-5 mt-5">
    @if(count($posts)>0)
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        @foreach($posts as $post)
        <div class="col mb-5">

            <div class="card h-100 shadow">

                <img class="card-img-top" src="{{ asset("storage/{$post->url}") }}" alt="imagen del post" />

                <div class="card-body p-4">
                    <div class="text-center">

                        <h5 class="fw-bolder">{{ $post->title }}</h5>

                        <div class="post-content">
                            <p>{{ $post->content }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('main.showpost',['id' => $post->id]) }}">Ver m&aacute;s</a></div>
                </div>
            </div>

        </div>
        @endforeach
    </div>
    @else
        <h3 class="text-center">No hay posts asociado a esta categoria!</h3>
    @endif
</div>
@endsection