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

        .tableSpecial{
          background: white;
        }

    </style>
</head>
<body>
  <img src="{{public_path().'/img/HeaderPDF.png'}}" alt="">
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
            <td><b>{{$requestService->correlativo}}</b></td>
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
          <td><b>ATENCIÓN FIRMA ELECTRÓNICA </b></td>
          <td><b>(0212)-5358998</b></td>
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
            <th style="min-width: 100px">SERVICIO</th>
            <th>CANTIDAD DE PETROS</th>
            <th>CANTIDAD SOLICITADA</th>
            <th>SUBTOTAL</th>
            <th>IVA</th>
            <th>TOTAL</th>
          </tr>
          @foreach ($requestService->services as $service)
            <tr>
                <td><b>{{$service->name}}</b></td>
                <td><b>{{$service->pivot->petro_quantity}}</b></td>
                <td><b>{{$service->pivot->quantity}}</b></td>
                <td><b>{{number_format($service->pivot->subtotal,2,'.',',')}} Bs.S</b></td>
                <td><b>{{number_format($service->pivot->iva,2,'.',',')}} Bs.S</b></td>
                <td><b>{{number_format($service->pivot->total,2,'.',',')}} Bs.S</b></td>
            </tr>
        @endforeach
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>ESTADO DE LA SOLICITUD</th>
        </tr>
        <tr>
          <td>
            @if ($requestService->status == 'Creado' || $requestService->status == 'Revisado')
              <h3 style="color:blue; font-size: 18px">
                {{$requestService->status}}
              </h3>
            @endif
            @if ($requestService->status == 'Aprobado' || $requestService->status == 'Completado')
              <h3 style="color:green; font-size: 18px">
                {{$requestService->status}}
              </h3>
            @endif
            @if ($requestService->status == 'Rechazado')
              <h3 style="color:red; font-size: 18px">
                {{$requestService->status}}
              </h3>
            @endif
          </td>
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
              <td><b>Oriolla Caballero</b></td>
            </tr>
            <tr>
              <td><b>JEFE DEL CENTRO DE SEGURIDAD INFORMÁTICA Y CERTIFICACIÓN ELECTRÓNICA (CSICE) </b></td>
            </tr>
        </table>
      </div>

      <div style="margin-top:10px;width:703px; text-align:center;">
        <h3>Firma del solicitante</h3>
        <table style="margin-top:10px" border="1">
            <tr>
              <th>POR EL CLIENTE</th>
            </tr>
            <tr>
              <td style="height: 70px !important"></td>
            </tr>
            <tr>
              <td><b>Por favor notificar por correo electrónico la aceptación de la presente oferta.</b></td>
            </tr>
        </table>
      </div>
    @endif

    @if($requestService->user->id !== 4)
    <div style="margin-top:80px;width:703px; text-align:center;">
      <h3>Condiciones de la oferta</h3>
      <table style="margin-top:10px" border="1">
          <tr>
            <th>1.- CONDICIONES GENERALES DE LA OFERTA</th>
          </tr>
          <tr>
            <th>1.1.- ACEPTACIÓN DE LA OFERTA:</th>
          </tr>
          <tr>
            <td>
              <b>
                En caso de aceptación de la presente oferta, el cliente deberá enviar una copia de ésta firmada y sellada, junto al comprobante bancario del pago o en caso de no poder realizar el pago por vencimiento de la firma enviar un documento de compromiso tipo Orden de Compra u Orden de Servicio, al mismo correo electrónico (atencion.cliente.psc.fii@gmail.com) donde recibió esta Oferta de Servicio.
                  <br><br>
                  <span>DATOS QUE DEBE CONTENER LA ORDEN DE SERVICIO U ORDEN DE COMPRA:</span>
                  <br><br>

                  <ul style="text-align:start">
                    <li><b>Datos completos de Facturación:</b> Nombre de la Empresa, RIF, Dirección Fiscal Completa, Persona Contacto, Número de Teléfono.
                    </li>
                    <li><b>Datos del Cliente para el Informe:</b> Nombre de la Empresa, RIF, Dirección Fiscal Completa, Persona Contacto, Número de Teléfono.</li>
                  </ul>
              </b>
            </td>
          </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>1.2 - FORMAS DE PAGO</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              Para todo lo relacionado con los pagos y antes de realizar el mismo, se recomienda al cliente comunicarse con la persona contacto de Administración para aclarar cualquier detalle relacionado con la Oferta.
              <br><br>
              PAGOS MEDIANTE DEPÓSITOS O TRANSFERENCIAS BANCARIA: Deberán realizarse a la <span style="color:#8f0923">Cuenta Corriente N°  0102-0552-21-0000059831, perteneciente al Banco de Venezuela, a nombre de la FUNDACIÓN INSTITUTO DE INGENIERÍA</span>.
              <br><br>
              El comprobante de pago Bancario deberá hacerse llegar a la Oficina de Facturación y Cobranza de la Fundación Instituto de Ingeniería, a la Persona Contacto de Administración; bien sea personalmente o por correo electronico.
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>1.3 - IVA e ISLR</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              Esta oferta contempla el Impuesto al Valor Agregado (IVA). El mismo esta expresado en el monto total del servicio.
              <br>
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>2 - CONDICIONES PARA EL PRÉSTAMO DEL SERVICIO</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              1.- Esta oferta tendrá una vigencia de quince (15) días para su ejecución a partir de la aceptación de la misma, si no es ejecutada en el tiempo indicado el cliente deberá cancelar la diferencia de su costo inicial, en caso de que exista una variación de precios decretada por las autoridades del Instituto de Ingeniería al momento de su ejecución.
              <br><br>
              2.- Las condiciones y políticas del ciclo de vida del certificado electrónico, emitido por el Proveedor de Servicios de Certificación Electrónica de la Fundación Instituto de Ingeniería para la Investigación y Desarrollo Tecnológico, esta disponible en el sitio web: https://publicador-psc.fii.gob.ve/dpc
              <br><br>
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>2.1.- CONDICIONES DE PAGO:</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              Cancelar al recibir la Oferta de Servicio en el plazo de la vigencia de la misma. De no cancelar durante ese lapso volver a solicitar una Oferta de Servicio.
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>2.2.- CONDICIONES DE GARANTÍA:</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              El cliente podrá solicitar a la Fundación Instituto de Ingeniería la sustitución de la tarjeta criptográfica en caso de desperfecto, siempre y cuando la falla no se deba a un mal uso por parte del cliente, para ello se debe dirigir a las Oficinas de Certificación Electronica para realizar la verificación de la misma.
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>2.3.- ENTREGA DE CERTIFICADOS ELECTRÓNICOS:</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              El plazo mínimo para la emisión de Certificados Electrónicos será de cuarenta y ocho (48) horas posteriores a la recepción de la Orden de Servicio o de Compra, y a su vez que se hayan cumplido con los requisitos para la solicitud. En el caso de que el cliente solicite la ejecución de jornadas para validar a los signatarios debe ver la sección 2.4. Políticas para Ejecución de Jornadas.
              <br><br>
              Para realizar la emisión de los Certificados Electrónicos en las instalaciones de la Fundación Instituto de Ingeniería, deberá  efectuarse mediante previa notificación por parte del Cliente, es decir, deben comunicarse a través del número de atención (0212)-5358998 en horario de oficina de 9:00 AM-12:00 PM y de 1:00 PM-4:00 PM, e indicar el día y la hora en que asistiran para la emisión del certificado electrónico, ya que estamos trabajando por citas.
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>2.4.- POLÍTICAS PARA EJECUCIÓN DE JORNADAS:</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              Para realizar la ejecución de las Jornadas que ofrece el Centro de Seguridad Informática y Certificación Electrónica (CSICE), se cumple con las siguientes especificaciones:
              <br><br>
              2.4.1.- Jornada de Validación: realizada para un máximo de 15 signatarios, donde el número de jornadas corresponden a la cantidad de certificados solicitados por el cliente.
              <br><br>
              2.4.2.- Jornada de Sensibilización sobre el uso de la Certificación Electrónica: realizada para un máximo de 30 participantes, con una duración aproximada de dos (2) horas. La cantidad de jornadas para los casos de emisión de certificados por primera vez se recomienda que tenga relación con la cantidad de signatarios a ser validados. Para aquellos casos en los que se desea conocer sobre el tema de la Certificación Electrónica el cliente debe indicar la cantidad de jornadas que necesita.
              <br><br>
              2.4.3.- Jornada de Aspectos Técnicos de la Certificación Electrónica: realizada para un máximo de 15 participantes, con una duración aproximada de dos (2) horas. Este tipo de jornada esta enfocada para el departamento, gerencia o área de tecnología de la institución solicitante, con la finalidad de formar al personal técnico en el uso, administración y soporte de los certificados electrónico.
              <br><br>
              2.4.4.- Jornada sobre Marco Jurídico de la Certificación Electrónica: realizada para un máximo de 15 participantes, con una duración aproximada de tres (3) horas. Este tipo de jornada esta enfocada tanto para el departamento legal, auditoria interna, como para aquellas personas que el cliente considere que deben manejar las leyes, estándares y normas establecidas para dar soporte jurídico a la firma electrónica y demás servicios de la certificación electrónica.
              <br><br>
              En los casos en que el cliente no disponga del espacio para realizar las Jornadas de Sensibilización, Técnica y Marco Jurídico, la Fundación Instituto de Ingeniería puede gestionar el espacio dentro de sus instalaciones, sin embargo será cargado al precio de la jornada los costos relacionados a refrigerios y organización.
            </b>
          </td>
        </tr>
      </table>
    </div>

    @else
    <div style="margin-top:80px;width:703px; text-align:center;">
      <h3>Condiciones de la oferta</h3>
      <table style="margin-top:10px" border="1">
          <tr>
            <th>1.- CONDICIONES GENERALES DE LA OFERTA</th>
          </tr>
          <tr>
            <th>1.1.- ACEPTACIÓN DE LA OFERTA:</th>
          </tr>
          <tr>
            <td>
              <b>
                En caso de aceptación de la presente oferta, el cliente deberá enviar una copia de ésta firmada y sellada, junto al comprobante bancario del pago o en caso de no poder realizar el pago por vencimiento de la firma enviar un documento de compromiso tipo Orden de Compra u Orden de Servicio, al mismo correo electrónico (atencion.cliente.psc.fii@gmail.com) donde recibió esta Oferta de Servicio.
                  <br><br>
                  <span>DATOS QUE DEBE CONTENER LA ORDEN DE SERVICIO U ORDEN DE COMPRA:</span>
                  <br><br>

                  <ul style="text-align:start">
                    <li><b>Datos completos de Facturación:</b> Nombre de la Empresa, RIF, Dirección Fiscal Completa, Persona Contacto, Número de Teléfono.
                    </li>
                    <li><b>Datos del Cliente para el Informe:</b> Nombre de la Empresa, RIF, Dirección Fiscal Completa, Persona Contacto, Número de Teléfono.</li>
                  </ul>
              </b>
            </td>
          </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>1.2 - FORMAS DE PAGO</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              Para todo lo relacionado con los pagos y antes de realizar el mismo, se recomienda al cliente comunicarse con la persona contacto de Administración para aclarar cualquier detalle relacionado con la Oferta.
              <br><br>
              PAGOS MEDIANTE DEPÓSITOS O TRANSFERENCIAS BANCARIA: Deberán realizarse a la <span style="color:#8f0923">Cuenta Corriente N°  0102-0552-21-0000059831, perteneciente al Banco de Venezuela, a nombre de la FUNDACIÓN INSTITUTO DE INGENIERÍA</span>.
              <br><br>
              El comprobante de pago Bancario deberá hacerse llegar a la Oficina de Facturación y Cobranza de la Fundación Instituto de Ingeniería, a la Persona Contacto de Administración; bien sea personalmente o por correo electronico.
            </b>
            <br><br>
          </td>
        </tr>
      </table>
  
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>2 - CONDICIONES PARA EL PRÉSTAMO DEL SERVICIO</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              1.- Esta oferta tendrá una vigencia de quince (15) días para su ejecución a partir de la aceptación de la misma, si no es ejecutada en el tiempo indicado el cliente deberá cancelar la diferencia de su costo inicial, en caso de que exista una variación de precios decretada por las autoridades del Instituto de Ingeniería al momento de su ejecución.
              <br><br>
              2.- Las condiciones y políticas del ciclo de vida del certificado electrónico, emitido por el Proveedor de Servicios de Certificación Electrónica de la Fundación Instituto de Ingeniería para la Investigación y Desarrollo Tecnológico, esta disponible en el sitio web: https://publicador-psc.fii.gob.ve/dpc
              <br><br>
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>2.1.- CONDICIONES DE PAGO:</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>
              Cancelar al recibir la Oferta de Servicio en el plazo de la vigencia de la misma. De no cancelar durante ese lapso volver a solicitar una Oferta de Servicio.
            </b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>2.2.- OBJETIVO GENERAL:</th>
        </tr>
        <tr>
          <td style="text-align:start">
            <b>Prestación del servicio de soporte en el componente de Firma Electrónica, así como lo referente a la generación y revocación de certificados electrónicos para ambientes de certificación y ambiente de producción, esto con el fin de contar con los mecanismos para alertar sobre las desviaciones detectadas en la operación de este servicio, de acuerdo a lo especificado en los procesos y procedimientos definidos para el mismo.</b>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>2.3.- NORMAS:</th>
        </tr>
        <tr>
          <td style="text-align:left">
            <b>
              Generales:
              <br><br>
              Las normas a seguir para el uso de los niveles escalatorios en la prestación del servicio son las siguientes:
              <br><br>
              1.- La FII garantizará el cumplimiento de las normas y procedimientos señalados en la oferta.
              <br><br>
              2.- Será responsabilidad de la FII asegurar la divulgación, conocimiento, aplicación de los pasos y procedimientos establecidos en esta oferta, a todo el personal que recibe asistencia así como los que prestan el servicio.
              <br><br>
              3.- Será responsabilidad de la FII revisar este documento y actualizarlo en el momento que sea requerido por nuevas exigencias del cliente.
              <br><br>
              4.- Será responsabilidad de la FII notificar a los involucrados acerca de cualquier modificación de la que sea objeto la presente oferta.
              <br><br>
              5.- En caso de ser aprobada la presente oferta de servicios tecnológicos, será responsabilidad de la FII el diseño del documento de definición de acuerdos de nivel de servicio, contentivo de los lineamientos por los cuales se rige esta oferta, así como los términos generales para la prestación de todos los servicios y el establecimiento de las responsabilidades que tienen tanto la “FII” como “El Cliente” para el buen cumplimiento del contrato, siendo el mencionado documento objeto de firma por ambas partes involucradas cuando éstas lo determinen.
              <br><br>
              Específicas:
              <br><br>
              1.- Es responsabilidad de la FII cumplir con el esquema de niveles escalatorios descritos en la tabla expuesta en la Sección 2.4, punto 5. Estos niveles serán utilizados cada vez que se requiera generar alertas en aquellas transacciones que demanden el empleo de los servicios ofrecidos por la aplicación de firma electrónica (SOFE), las cuales hayan excedido los tiempos estimados de respuesta.
              <br><br>
              2.- Las áreas en las que se requeriría activar el mecanismo de escalamiento son las siguientes:
              <br>
              <b style="margin-left: 10px">* Administración de Glassfish.</b>
              <br>
              <b style="margin-left: 10px">* Clustering asociado al SOFE.</b>
              <br>
              <b style="margin-left: 10px">* Administración de Usuario para uso del Web Service de Firma Electrónica.</b>
              <br>
              <b style="margin-left: 10px">* Configuración de dominios para uso del Web Service de Firma Electrónica.</b>
              <br>
              <b style="margin-left: 10px">* Servicios prestados a través de la aplicación SOFE (generación y validación de la firma electrónica).</b>
              <br>
              <b style="margin-left: 10px">* Comunicación entre el SOFE y los distintos SIP.</b>
              <br>
              <b style="margin-left: 10px">* Generación y revocación de certificados electrónicos.</b>
              <br><br>
              3.- La comunicación del incidente podrá realizarse mediante correo electrónico o llamada telefónica.
              <br><br>
              4.- Una vez resuelta la situación, el responsable a cargo del nivel respectivo deberá notificar al usuario y a su supervisor de área, la resolución del incidente a través de cualquiera de las modalidades señaladas en el punto anterior.
            </b>
            <br><br>
          </td>
        </tr>
      </table>
      <table style="margin-top:-3px" border="1">
        <tr>
          <th>2.4.- ESQUEMA:</th>
        </tr>
        <tr>
          <td style="text-align:left">
            <b>
              Para realizar la ejecución de las Jornadas que ofrece el Centro de Seguridad Informática y Certificación Electrónica (CSICE), se cumple con las siguientes especificaciones:
              <br><br>
              1.- El cliente detecta la irregularidad en alguna de las áreas descritas en el punto 2 de las normas específicas.
              <br><br>
              2.- El cliente ejecuta una llamada telefónica al primer nivel de escalamiento y espera el tiempo indicado.
              <br><br>
              3.- El representante del nivel contactado deberá gestionar la solución a la alarma reportada y dar respuesta de las acciones tomadas en el tiempo establecido para ello.
              <br><br>
              4.- De no recibir respuesta, el cliente podrá activar los niveles sucesivos disponibles.
              <br><br>
              5.- A continuación se muestra el nivel de escalamiento:
              <br><br>
            </b>
          </td>
        </tr>
      </table>
      <table border="1">
        <tr>
          <th class="tableSpecial">
            NIVEL 1: PERSONAL DE GUARDIA 
            <br> 
            Tiempo: 30min.
            <br> 
            Tlfn: (0212) 5358998.
          </th>

          <th class="tableSpecial">
            NIVEL 2: JEFE DEL CSICE 
            <br> 
            Tiempo: 45min.
            <br> 
            Tlfn: (0414) 2263729.
          </th>

          <th class="tableSpecial">
            NIVEL 3: PRESIDENCIA 
            <br> 
            Tiempo: 60min,.
            <br> 
            Tlfn: (0416) 6223177.
          </th>
        </tr>
      </table>
      <table border="1">
        <tr>
          <td style="margin-top: 3px; text-align: left">
            <b>El nivel de escalamiento para la atención del requerimiento solicitado debe estar sujeto a los tiempos establecidos en el punto anterior, de lo contrario, la solicitud no tendrá validez y debe realizarse un nuevo requerimiento.</b>
            <br><br>
          </td>
        </tr>
      </table>

      <table  border="1">
        <tr>
          <th>DURACIÓN:</th>
        </tr>
        <tr>
          <td style="text-align: left">
            <b>El Servicio tiene una duración de un (01) año, a partir de la Fecha de aprobación de la oferta de servicio.</b>
          </td>
        </tr>
      </table>

      <table border="1">
        <tr>
          <th>FECHA DE INICIO Y CULMINACIÓN DEL SERVICIO:</th>
        </tr>
        <tr>
          <td style="text-align: left">
            <b>Fecha de Inicio: {{$requestService->start_date}}</b>
            <br>
            <b>Fecha de Culminación: {{$requestService->expiration_date}}</b>
            <br><br>
          </td>
        </tr>
      </table>

      <table border="1">
        <tr>
          <th>CONDICIONES DEL SERVICIO DE SOPORTE:</th>
        </tr>
        <tr>
          <td style="text-align: left">
            <b>
              1.- La FII se compromete a prestar soporte técnico a las operaciones directamente relacionadas con la aplicación SOFE.
              <br><br>
              2.- El cliente se compromete a notificar con al menos diez días hábiles de antelación cualquier cambio en los sistemas involucrados con el funcionamiento del SOFE que pueda afectar operaciones críticas.
              <br><br>
              3.- La FII podrá dar soporte en sitio ante fallas inesperadas de SOFE que afecten de forma directa operaciones críticas de los sistemas del cliente.
              <br><br>
              4.- La FII no dará, dentro del alcance de esta oferta, soporte en sitio a usuarios finales de certificados electrónicos o usuarios finales de los sistemas relacionados con SOFE. 
              <br><br>
              5.- El Servicio no incluye fines de semana, ni días feriados.
              <br><br>
              6.- No incluye los costos de emisión de certificados electrónicos, estos se cotizarán aparte en el momento de la solicitud.
              <br><br>
              7.- El alcance de los servicios será como máximo de 120 horas laborables en sitio, distribuidos en el lapso de duración del contrato.
              <br><br>
            </b>
          </td>
        </tr>
      </table>
    </div>
    @endif



</body>
</html>
