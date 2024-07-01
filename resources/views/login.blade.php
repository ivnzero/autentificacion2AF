<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="col-12-md mt-5">
            <div class="text-center">
                <h1>Login</h1>
            </div>

            <form class="row" method="POST">
                @csrf
                <div class="form-group col-md-12">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input name="usuario" id="usuario" type="text" class="form-control">
                </div>

                <div class="form-group col-md-12">
                    <label for="contrasenia" class="form-label">Contraseña</label>
                    <input name="contrasenia" id="contrasenia" type="password" class="form-control">
                </div>

                @if(isset($mensaje))
                <div class="alert alert-warning text-center mt-3" role="alert">
                    <h6>{!! $mensaje !!}</h6>
                </div>
                @endif

                <button class="btn btn-primary mt-2">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>