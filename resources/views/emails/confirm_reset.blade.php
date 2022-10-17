<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Hola {{ $name }}, Enhorabuena tu contraseña ha sido restablecida correctamente !</h2>
    <p>ya puedes ingresar a tu cuenta de <strong>CSICE</strong>! con tu nueva clave de acceso.</p>

    <a href="{{ url('/login') }}">
        Click para ingresar a tu cuentas
    </a>
</body>
</html>