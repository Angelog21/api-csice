<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    Hola {{ $requestService->user->name }}, gracias por solicitar el servicio <h2><strong>{{$requestService->service->name}}</strong></h2>
    a través de nuestra plataforma.
    @if ($requestService->status == 'Aprobado')
        <p>
            Es de nuestro agrado informarle que para culminar el proceso de su solicitud es necesario que adjunte a través de nuestra plataforma de Sistema de Gestión de Servicios de Firma electrónica los archivos correspondientes, es decir, en caso de ser:

            <ul>
                <li>
                    Comprobante de pago en formato (png, jpeg, jpg, pdf)
                </li>
            </ul>
        </p>
    @elseif ($requestService->status == 'Creado')
        <p>
            Es de nuestro agrado informarle que su solicitud ha sido creada, es necesario que adjunte a través de nuestra plataforma de Sistema de Gestión de Servicios de Firma electrónica los archivos correspondientes, es decir, en caso de ser:

            <ul>
                <li>
                    Empleado Público adjuntar el RIF de la Institución, nombramiento o Gaceta y CI. del Signatario.
                </li>
                <li>
                    Persona Natural adjuntar CI y RIF del signatario.
                </li>
                <li>
                    Persona Jurídica adjuntar RIF de la empresa, CI del signatario y Acta Constitutiva y nombramiento
                </li>
            </ul>
        </p>
    @else
        <p>
            Para esta ocasión su solicitud ha sido rechazada
        </p>
    @endif
    <p>Le invitamos a seguir usando nuestra plataforma para próximos procesos de gestión y solicitudes.</p>
</body>
</html>
