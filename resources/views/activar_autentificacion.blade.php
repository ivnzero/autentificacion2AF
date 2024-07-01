<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Activar 2AF</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
        <div class="col-12-md mt-5">
            <div class="text-center">
                <h1>Activar doble autentificación</h1>
            </div>

            <div class="col-md-12 text-center mt-5">
                <img src="{{$qrURL}}" alt="Imagen QR">
            </div>

            <form class="row mt-5" action="{{ route('activar2AF') }}" method="POST">
                @csrf
                <div class="btn-group offset-md-4 col-md-4 offset-2 col-8 mb-3">
                    <input class="form-control mx-1 text-center" type="text" name="digito-1">
                    <input class="form-control mx-1 text-center" type="text" name="digito-2">
                    <input class="form-control mx-1 text-center" type="text" name="digito-3">
                    <input class="form-control mx-1 text-center" type="text" name="digito-4">
                    <input class="form-control mx-1 text-center" type="text" name="digito-5">
                    <input class="form-control mx-1 text-center" type="text" name="digito-6">
                </div>
                <div class="offset-md-4 col-md-4 offset-2 col-8">
                    @if(isset($errorMessage))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>{!! $errorMessage !!}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="alert alert-primary" role="alert">
                        Utilice la aplicación de Google Authenticator para activar su doble verificación.
                        <!-- {{$codigo}} -->
                    </div>
                </div>
                <button class="btn btn-success offset-md-4 col-md-4 offset-2 col-8">Activar</button>
            </form>
        </div>
</body>
</html>