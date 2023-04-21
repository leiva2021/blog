@extends('layouts.public')

<style>
    #link-muted {
        color: #aaa;
    }

    #link-muted:hover {
        color: #1266f1;
    }
</style>

@section('content')
<div class="container">
    <div class="row">
        <div class="text-center">
            <div class="card shadow" style="background-color: #F4F6F6;">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p>Fecha: <span class="date">{{ $post->created_at->format('d \d\e F \d\e Y') }}</span></p>
                    <img style="width:600px;height:400px;" src="{{ asset("storage/{$post->url}") }}" class="img-thumbnail" alt="imagen del post">
                    <p>{{strip_tags($post->content)}}</p>

                    <a class="btn btn-success" data-bs-toggle="collapse" href="#collapseExamplecomment" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="bi bi-chat-quote-fill"></i> {{ count($comments)> 0 ? count($comments) : ''  }} Comentar</a>
                </div>

                <div class="mx-5 mb-3">
                    <div class="collapse" id="collapseExamplecomment">
                        <form action="{{ route('comment.store') }}" method="POST">
                            @csrf
                            <input type="hidden" id="post_id" name="post_id" value="{{ $post->id }}">
                            <div class="d-flex flex-start w-100">
                                <div class="form-outline w-100">
                                    <textarea class="form-control" placeholder="Ingrese su comentario..." name="body" id="body" rows="2" style="background: #fff;" required></textarea>
                                </div>
                            </div>
                            <div class="float-end mt-2 pt-1">
                                <button type="submit" class="btn btn-primary btn-sm">Publicar</button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-5">
                        @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                        @elseif (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <section style="background-color: #12465f;">
                <div class="container my-5 py-5">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12 col-lg-10 col-xl-8">


                            @if(count($comments)>0)

                            @foreach($comments as $comment)
                            <div class="card mt-2" style="background-color: #F2F4F4;">
                                <div class="card-body">
                                    <div class="d-flex flex-start align-items-center">
                                        <img class="rounded-circle shadow-1-strong me-3" src="https://xx.bstatic.com/static/img/review/avatars/ava-{{ strtolower(\Illuminate\Support\Str::limit($comment->name, 1, '')) }}.png" alt="avatar" width="60" height="60" />
                                        <div>
                                            <h6 class="fw-bold text-primary mb-1">{{ $comment->name }}</h6>
                                            <p class="text-muted small mb-0">
                                                Compartido publicamente - {{ \Carbon\Carbon::parse($comment->created_at)->locale('es')->isoFormat('LL') }}
                                            </p>
                                        </div>
                                    </div>

                                    <p class="mt-3 mb-4 pb-2">
                                        {{ $comment->body }}
                                    </p>

                                    <div class="small d-flex justify-content-start">
                                        <a href="#!" id="link-muted" class="d-flex align-items-center me-3"><i class="fas fa-thumbs-up me-1"></i>132</a>
                                        <a href="#!" id="link-muted" class="d-flex align-items-center me-3"><i class="fas fa-thumbs-down me-1"></i>15</a>
                                        <a data-bs-toggle="collapse" href="#collapseExample{{ $comment->id }}" role="button" aria-expanded="false" aria-controls="collapseExample" id="link-muted" class="d-flex align-items-center me-3"><i class="far fa-comment-dots me-2"></i>Comentar</a>
                                    </div>
                                </div>
                                <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">

                                    <div class="collapse" id="collapseExample{{ $comment->id }}">

                                        <div class="d-flex flex-start w-100">
                                            <img class="rounded-circle shadow-1-strong me-3" src="https://xx.bstatic.com/static/img/review/avatars/ava-{{ strtolower(\Illuminate\Support\Str::limit($comment->name, 1, '')) }}.png" alt="avatar" width="40" height="40" />
                                            <div class="form-outline w-100">
                                                <textarea class="form-control" placeholder="Responder..." id="textAreaExample" rows="2" style="background: #fff;"></textarea>
                                            </div>
                                        </div>
                                        <div class="float-end mt-2 pt-1">
                                            <button type="button" class="btn btn-primary btn-sm">Publicar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <h5 class="text-center text-light">Sin comentarios!!</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@vite(['resources/css/mystyle.scss'])

@endsection