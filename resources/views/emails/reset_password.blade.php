<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Hola {{ $name }}, bienvenido a <strong>CSICE</strong>!</h2>
    <p>Hemos recibido una solicitud de restablecimiento de contraseña, si no fuiste tu ignora este email.</p>
    <p>De lo contrario debes hacer click en el siguiente enlace:</p>

    <a href="{{env("FRONT_URL")}}/recoverPass/{{ $remember_token }}">
        Click para recuperar el acceso a tu cuenta.
    </a>
</body>
</html>