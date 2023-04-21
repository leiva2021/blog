<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Blogs</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('storage/assets/public/css/styles.css')}}" rel="stylesheet" />

    <!--font awesome con CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!" style="background-color: #6C3483; padding: 7px;border-radius: 3px; color:white;">Contenidos&M&aacute;s</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('main') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('main.about') }}">Sobre nosostros</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categor&iacute;as</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach($categories as $category)
                            <li><a class="dropdown-item" href="{{ route('main.filterpostsbycategory',['id' => $category->id]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('public.index') }}">Iniciar sesion</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Bienvenido!!</h1>
                <p class="lead fw-normal text-white-50 mb-0">Espacio donde podrás encontrar los mejores temas de su agrado."</p>
            </div>
        </div>
    </header>

    <!-- Section-->
    <section class="py-5">
        @yield('content')
    </section>
    <!-- Footer-->

    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; contenido&Mas 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{asset('storage/assets/public/js/scripts.js')}}"></script>
</body>

</html>