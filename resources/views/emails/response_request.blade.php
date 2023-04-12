<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    Hola {{ $requestService->user->name }}, gracias por solicitar el servicio <h2><strong>{{$requestService->service->name}}</strong></h2>
    a través de nuestra plataforma.
    @if ($requestService->status == 'Aprobado')
        <p>
            Es de nuestro agrado informarle que su solicitud ha sido aprobada, debe ingresar nuevamente a nuestra plataforma de Sistema de Gestión de Servicios de Firma Electrónica para que pueda culminar el proceso administrativo pertinente a su solicitud para ello es necesario que adjunte el

            <ul>
                <li>Comprobante de pago en formato (png, jpeg, jpg o pdf) y marque la fecha de la cita para agendar la atención del signatario.</li>
            </ul>

            Una vez realizado este procedimiento por favor comuníquese a través del número de atención 0212-5358998 para que indique la hora en que asistirá el signatario a nuestras oficinas para la emisión de su certificado electrónico.
            
            Muy respetuosamente les recordamos que este es un tramite legal e intransferible a un tercero, por tal motivo es indispensable que el signatario este de manera presencial en la emisión de su certificado electrónico.
        </p>
    @elseif ($requestService->status == 'Creado')
        <p>
            Es de nuestro agrado informarle que su solicitud ha sido creada, la misma será evaluada para validar que los datos solicitados hayan sido ingresados correctamente y a su vez corroborar la carga de los archivos correspondientes a la solicitud.
        </p>
    @else
        <p>
            Muy respetuosamente le informamos que en esta ocasión su solicitud ha sido rechazada para mayor información por favor comuníquese a través de nuestro número de atención 0212-5358998.
        </p>
    @endif
    <p>Le invitamos a seguir usando nuestra plataforma para próximos procesos de gestión y solicitudes.</p>
</body>
</html>
