<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body{
          font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          color: rgb(71, 71, 71);
          font-size: 10px;
        }
        img{
            width: 100%;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th{
          background-color: rgb(207, 207, 207);
        }

        td {
          text-align: center;
        }

    </style>
</head>
<body>
    <img src="{{public_path().'/img/headerPDF.png'}}" alt="">
    <div style="margin-top:20px;width:703px">
      <table style="margin-top:10px" border="1">
          <tr>
            <th>RAZÓN SOCIAL</th>
            <th>RIF</th>
            <th>TELÉFONO</th>
          </tr>
          <tr>
            <td><b>FUNDACIÓN INSTITUTO DE INGENIERÍA</b></td>
            <td><b>G-20004650-3</b></td>
            <td><b>(0212) 903-46-13</b></td>
          </tr>
      </table>
    </div>
    <table style="margin-top:10px" border="1">
      <tr>
        <th>DIRECCIÓN FISCAL:</th>
      </tr>
      <tr>
        <td><b>Carretera Nacional Hoyo de la Puerta Urb. Monte Elena II, Altos de Sartenejas, BARUTA-EDO. MIRANDA. Zona Postal 1080. </b></td>
      </tr>
    </table>
    <div style="margin-top:20px;width:703px">
      <table style="margin-top:10px" border="1">
          <tr>
            <th>NÚMERO DE OFERTA</th>
            <th>FECHA DE LA OFERTA</th>
            <th>DURACIÓN DE LA OFERTA (DÍAS)</th>
            <th>FECHA CADUCIDAD</th>
          </tr>
          <tr>
            <td><b>{{$requestService->id}}</b></td>
            <td><b>{{substr($requestService->created_at,0,10)}}</b></td>
            <td><b>15</b></td>
            <td><b>{{$requestService->expiration_date}}</b></td>
          </tr>
      </table>
    </div>

    <div style="margin-top:10px;width:703px; text-align:center;">
      <h3>Datos del cliente</h3>
      <table style="margin-top:10px" border="1">
          <tr>
            <th>RAZÓN SOCIAL</th>
            <th>RIF</th>
            <th>TELÉFONO</th>
          </tr>
          <tr>
            <td><b>{{$requestService->user->social_reason}}</b></td>
            <td><b>{{$requestService->user->rif}}</b></td>
            <td><b>{{$requestService->user->phone}}</b></td>
          </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>PERSONA DE CONTACTO</th>
          <th>CORREO ELECTRÓNICO</th>
        </tr>
        <tr>
          <td><b>{{$requestService->user->name}}</b></td>
          <td><b>{{$requestService->user->email}}</b></td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>DIRECCIÓN FISCAL</th>
        </tr>
        <tr>
          <td><b>{{$requestService->user->direction}}</b></td>
        </tr>
      </table>
    </div>

    <div style="margin-top:10px;width:703px; text-align:center;">
      <h3>Datos dependencia ejecutora del servicio</h3>
      <table style="margin-top:10px" border="1">
          <tr>
            <th>CENTRO EJECUTOR DEL SERVICIO</th>
            <th>UNIDAD EJECUTORA DEL SERVICIO</th>
          </tr>
          <tr>
            <td><b>CENTRO DE SEGURIDAD INFORMÁTICA Y CERTIFICACIÓN ELECTRÓNICA (CSICE)</b></td>
            <td><b>UNIDAD DE OPERACIONES Y SERVICIOS</b></td>
          </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>PERSONA DE CONTACTO ÁREA TÉCTICA</th>
          <th>CONTACTO</th>
        </tr>
        <tr>
          <td><b>CLARITZA RIVERA </b></td>
          <td><b>(0426) 610-62-78</b></td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>PERSONA DE CONTACTO ÁREA ADMINISTRATIVA</th>
          <th>CORREO ELECTRÓNICO</th>
        </tr>
        <tr>
          <td><b>YAURI JACKSON</b></td>
          <td><b>facturafii@gmail.com</b></td>
        </tr>
      </table>
    </div>

    <div style="margin-top:10px;width:703px; text-align:center;">
      <h3>Datos del servicio</h3>
      <table style="margin-top:10px" border="1">
          <tr>
            <th>CÓDIGO</th>
            <th style="min-width: 100px">DESCRIPCIÓN</th>
            <th>UNIDAD</th>
          </tr>
          <tr>
            <td><b>{{$requestService->service->code}}</b></td>
            <td><b>{{$requestService->service->name}}</b></td>
            <td><b>{{$requestService->service->unit}}</b></td>
          </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>CANTIDAD</th>
          <th>SUBTOTAL</th>
          <th>IVA</th>
          <th>TOTAL</th>
        </tr>
        <tr>
          <td><b>{{$requestService->quantity}}</b></td>
          <td><b>{{number_format($requestService->price,2,'.',',')}} Bs.S</b></td>
          <td><b>{{number_format($requestService->iva,2,'.',',')}} Bs.S</b></td>
          <td><b>{{number_format($requestService->total,2,'.',',')}} Bs.S</b></td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>ESTADO DE LA SOLICITUD</th>
        </tr>
        <tr>
          <td><h3 style="color:blue;font-size:14px">{{$requestService->status}}</h3></td>
        </tr>
      </table>
    </div>
    @if ($requestService->status != 'Creado' && $requestService->status != 'Rechazado') 
      <div style="margin-top:10px;width:703px; text-align:center;">
        <h3>Datos de la respuesta</h3>
        <table style="margin-top:10px" border="1">
            <tr>
              <th>APROBADO POR</th>
            </tr>
            <tr>
              <td><b>Edixon Rojas</b></td>
            </tr>
            <tr>
              <td><b>JEFE DEL CENTRO DE SEGURIDAD INFORMÁTICA Y CERTIFICACIÓN ELECTRÓNICA (CSICE) </b></td>
            </tr>
        </table>
      </div>
    @endif

    <div style="margin-top:10px;width:703px; text-align:center;">
      <h3>Condiciones de la oferta</h3>
      <table style="margin-top:10px" border="1">
          <tr>
            <th>REQUISITOS</th>
          </tr>
          <tr>
            <td>
              <b>
                En caso de aceptación de la presente oferta, el cliente deberá enviar una copia de ésta firmada y sellada, junto con un documento de compromiso tipo Orden de Compra u Orden de Servicio, al número de fax indicado o en físico en nuestras oficinas.
                  <ul style="text-align:start">
                    <li>Nombre de la Empresa</li>
                    <li>RIF</li>
                    <li>Dirección Fiscal Completa</li>
                    <li>Persona Contacto</li>
                    <li>Teléfono</li>
                    <li>Fax</li>
                  </ul>
              </b>
            </td>
          </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>FORMAS DE PAGO</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              Para todo lo relacionado con los pagos y antes de realizar el mismo, se recomienda al cliente comunicarse con la persona contacto de Administración para aclarar cualquier detalle relacionado con la Oferta.
              <br><br>
              PAGOS EN CHEQUES: Serán realizados a nombre del FUNDACIÓN INSTITUTO DE INGENIERÍA, y deberán ser entregados en la Oficina de Facturación y Cobranza del Instituto de Ingeniería, a la persona contacto de Administración.
              <br><br>
              PAGOS MEDIANTE DEPÓSITOS O TRANSFERENCIAS BANCARIA : Deberán realizarse a la Cuenta Corriente N° 0102-0552-21-0000059831, perteneciente al Banco de Venezuela, a nombre de la FUNDACIÓN INSTITUTO DE INGENIERÍA.
              <br><br>
              El comprobante del Depósito Bancario deberá hacerse llegar a la Oficina de Facturación y Cobranza de la Fundación Instituto de Ingeniería, a la Persona Contacto de Administración; bien sea personalmente, mensajería o al número de fax indicado.
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>CONDICIONES PARA EL PRÉSTAMO DEL SERVICIO</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              El plazo mínimo para la emisión de Certificados Electrónicos será de cuarenta y ocho (48) horas posteriores a la recepción de la Orden de Servicio o de Compra, y a su vez que se hayan cumplido con los requisitos para la solicitud. En el caso de que el cliente solicite la ejecución de jornadas para validar a los signatarios debe ver la siguiente sección.
              <br><br>
              Para realizar el retiro de los Certificados Electrónicos en las instalaciones de la Fundación Instituto de Ingeniería, deberá  efectuarse mediante previa notificación por parte del Cliente en horario de oficina 8:30 am-12:00 pm y de 1:00 pm-4:30 pm.
              <br><br>
              El plazo para retirar los Certificados Electrónicos es diez (10) días hábiles a partir de la fecha en que se notifique al cliente de la culminación del servicio, después de los cuales el Instituto de Ingeniería no se hará responsable de los mismos.
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>ENTREGA DE CERTIFICADOS ELECTRÓNICOS</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              El plazo mínimo para la emisión de Certificados Electrónicos será de cuarenta y ocho (48) horas posteriores a la recepción de la Orden de Servicio o de Compra, y a su vez que se hayan cumplido con los requisitos para la solicitud. En el caso de que el cliente solicite la ejecución de jornadas para validar a los signatarios debe ver la siguiente sección.
              <br><br>
              Para realizar el retiro de los Certificados Electrónicos en las instalaciones de la Fundación Instituto de Ingeniería, deberá  efectuarse mediante previa notificación por parte del Cliente en horario de oficina 8:30 am-12:00 pm y de 1:00 pm-4:30 pm.
              <br><br>
              El plazo para retirar los Certificados Electrónicos es diez (10) días hábiles a partir de la fecha en que se notifique al cliente de la culminación del servicio, después de los cuales el Instituto de Ingeniería no se hará responsable de los mismos.
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>POLÍTICAS PARA EJECUCIÓN DE JORNADAS</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              Jornada de Validación: realizada para un máximo de 15 signatarios, donde el número de jornadas corresponden a la cantidad de certificados solicitados por el cliente.
              <br><br>
              Jornada de Sensibilización sobre el uso de la Certificación Electrónica: realizada para un máximo de 30 participantes, con una duración aproximada de dos (2) horas. La cantidad de jornadas para los casos de emisión de certificados por primera vez se recomienda que tenga relación con la cantidad de signatarios a ser validados. Para aquellos casos en los que se desea conocer sobre el tema de la Certificación Electrónica el cliente debe indicar la cantidad de jornadas que necesita.
              <br><br>
              Jornada de Aspectos Técnicos de la Certificación Electrónica: realizada para un máximo de 15 participantes, con una duración aproximada de dos (2) horas. Este tipo de jornada esta enfocada para el departamento, gerencia o área de tecnología de la institución solicitante, con la finalidad de formar al personal técnico en el uso, administración y soporte de los certificados electrónico.
              <br><br>
              Jornada sobre Marco Jurídico de la Certificación Electrónica: realizada para un máximo de 15 participantes, con una duración aproximada de tres (3) horas. Este tipo de jornada esta enfocada tanto para el departamento legal, auditoria interna, como para aquellas personas que el cliente considere que deben manejar las leyes, estándares y normas establecidas para dar soporte jurídico a la firma electrónica y demás servicios de la certificación electrónica.
            </b>
          </td>
        </tr>
      </table>
    </div>
</body>
</html>