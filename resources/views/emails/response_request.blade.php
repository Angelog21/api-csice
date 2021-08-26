<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    Hola {{ $requestService->user->name }}, gracias por solicitar el servicio <h2><strong>{{$requestService->service->name}}</strong></h2>
    a través de nuestra plataforma.
    @if ($requestService->status == 'Aprobado')
        <p>Es de nuestro agrado informarle que su soclicitud ha sido aprobada, debe descargar el archivo adjunto al correo para proceder la entrega de los recaudos y así poder ejecutar la entrega del servicio</p>
    @else
        <p>
            Para esta ocasión su solicitud ha sido rechazada
        </p>
    @endif
    <p>Le invitamos a seguir usando nuestra plataforma para próximos procesos de gestión y solicitudes.</p>
</body>
</html>