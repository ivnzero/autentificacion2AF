<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <h1>!Éxito, estas dentro del sistema.!</h1>

    <form action="{{ route('sayonara') }}" method="POST">
        @csrf
        <button class="btn btn-danger">Cerrar sesión</button>
    </form>
</body>
</html>