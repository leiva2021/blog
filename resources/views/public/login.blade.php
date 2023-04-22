<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <section class="vh-100" style="background-color: #F2F3F4;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form action="{{ route('public.authenticate') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2">Ingresar</button>
                            </form>
                            <p>No tiene una cuenta? <a style="text-decoration: none;" href="{{ route('public.create') }}">Registrate</a></p>
                            @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>


</html>