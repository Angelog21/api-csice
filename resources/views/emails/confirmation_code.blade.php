<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Hola {{ $name }}, gracias por registrarte en <strong>CSICE</strong>!</h2>
    <p>Por favor confirma tu correo electrónico.</p>
    <p>Para eso simplemente debes hacer click en el siguiente enlace:</p>

    <a href="{{ url('/register/verify/' . $confirmation_code) }}">
        Click para confirmar tu email
    </a>
</body>
</html>