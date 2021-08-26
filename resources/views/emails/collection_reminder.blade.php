<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    Hola {{ $user->name }}, el presente correo es para recordarle que debe cargar los recaudos para poder continuar con el proceso de gestión de su solicitud.
    <p>
        Para cargar sus archivos solo debe ingresar a <a href="{{env("FRONT_URL")}}/mis-solicitudes?openUpload=true">este enlace </a>
    </p>
</body>
</html>