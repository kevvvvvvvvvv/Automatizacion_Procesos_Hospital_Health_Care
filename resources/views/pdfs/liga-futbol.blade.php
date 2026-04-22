<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 10px; line-height: 1.2; }
        .header { border-bottom: 2px solid #33333333; margin-bottom: 10px; padding-bottom: 5px; }
        .title { font-size: 18px; font-weight: bold; color: #33333; font-style: italic; }
        
        .section-title { background-color: #f3e8ff; color: #6b21a8; font-weight: bold; padding: 3px 8px; text-transform: uppercase; font-size: 9px; border: 1px solid #ddd; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { padding: 4px;  text-align: left; }
        .label { font-weight: bold; color: #33333; text-transform: uppercase; font-size: 8px; }
        
        .box {border: 1px solid #ddd; border-radius: 4px; margin-bottom: 10px; overflow: hidden;}
        .cost-table td { border: 1px solid #ddd; font-size: 9px; }
        .highlight { color: #2563eb; font-weight: bold; }
        
        .footer-legal { border: 1px solid #eee; padding: 10px; text-align: justify; font-size:10px;  }
        .signature-line { border-top: 1px solid #000; width: 200px; margin-top: 35px; text-align: center; font-weight: bold; }
       /* .signature-line {
    border-top: 1px solid #000;
    width: 50%;
    margin-top: 35px; /* Ahora ocupa todo el ancho de su celda 
    text-align: center;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 9px;
    padding-top: 5px;
}*/
        .text-red { color: #dc2626; font-weight: bold; text-align: center; }
        .text-black { olor: #000; font-weight: bold; text-align: center; }
        .header-logo {float: left; width: 150px; margin-bottom: 10px;}
        .logo {width: 100%; height: auto; object-fit: contain;}
        .clearfix::after {content: "";clear: both;display: table;}
    </style>
    <title>Formato de la liga de futbol.</title>
</head>
<body>
    

    <div class="header">
        <div class="header-logo">
    <img src="{{ public_path('images/Logo_HC_2.png') }}" alt="Logo Hospital" class="logo">
</div>
        <table style="border: none;">
            <tr style="border: none;">
                <td style="border: none; width: 10%;">
                    <div class="title">LIGA DE FUTBOL</div>
                </td>
                <td style="border: none; width: 30%; text-align: right;">
                    <strong>FECHA:</strong> {{ date('d/m/Y') }}
                </td>
            </tr>
        </table>
    </div>

    <table>
        <tr>
            <td colspan="2"><span class="label">Nombre del Paciente: _________________________________________________</span></td>
            <td><span class="label">Fecha Evento: __________</span></td>
            <td><span class="label">Hora:__________</span> </td>
        </tr>
        <tr>
            <td colspan="2"><span class="label">Nombre del Padre o Tutor: __________________________________________</span></td>
            <td><span class="label">Hora Evento:____________</span></td>
            
        </tr>
        <tr>
            <td><span class="label">Tel. del Padre o Tutor:_________________</span> </td>
            <td><span class="label">Edad:__________</span> </td>
            <td colspan=""><span class="label">Fecha Nacimiento:____________________</span></td>
        </tr>
        <tr>
            <td colspan="2"><span class="label">Médico de Primer Contacto:__________________________________________</span></td>
            <td colspan="2"><span class="label">Equipo o Liga:_____________________________________</span> </td>
        </tr>
    </table>
    <div class="box">
        
        <div style="height: 270px;"></div>
    </div>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
    <tr>
        <td style="width: 32%; vertical-align: top; padding-right: 5px;">
            <div class="box">
                <div class="section-title">Consulta Post-Evento</div>
                <table class="cost-table">

                    <tr><td></td><td>3 HRS</td><td><strong>SIN COSTO</strong></td></tr>
                    <tr><td></td><td>48 HRS</td><td >$100.00 costo preferencial</td></tr>
                    <tr><td></td><td>mas de 48 HRS</td><td>$250.00 costo preferencial</td></tr>
                </table>
            </div>
            <div class="box">
                
                <div class="section-title">Hospitalización</div>
                <table class="cost-table">
                    <tr><td>   </td><td> 8 hrs - SIN COSTO</td></tr>
                </table>
                
            </div>
        </td>

        <td style="width: 32%; vertical-align: top; padding-right: 5px;">
            <div class="box">
                <div class="section-title">Especialidad (Traumatologia)</div>
                <table class="cost-table">
                    <tr><td></td><td>GRATIS</td><td>Emitida por el médico</td></tr>
                    <tr><td></td><td>$750.00</td><td>Si el asegurado lo solicita</td></tr>
                </table>
            </div>
            <div class="box">
                <div class="section-title">Rayos X</div>
                <table class="cost-table">
                    <tr><td></td><td>SIN COSTO</td><td>Si se tiene sospecha de fractura</td></tr>
                    <tr><td></td><td>$300.00</td><td>Si el familiar quiere que se le haga la toma</td></tr>
                </table>
            </div>
        </td>

       
    </tr>
</table>

    <table style="border: none;">
        <tr style="border: none;">
            <td style="width: 49%; border: none;">
                <div class="box">
                    <div class="section-title">Sesiones de Fisioterapia</div>
                    <table class="cost-table">
                        <tr><td></td><td>1era FISIOTERAPIA</td><td><strong>GRATIS</strong></td></tr>
                        <tr><td></td><td>A PARTIR DE LA SEGUNDA</td><td>$300.00</td></tr>
                    </table>
                </div>
            </td>
            <td style="width: 2%; border: none;"></td>
            <td style="width: 49%; border: none;">
                <div class="box">
                    <div class="section-title">Paquete Fisioterapias Adicionales</div>
                    <table class="cost-table">
                        <tr><td></td><td>$1,250.00</td><td>5 SESIONES</td></tr>
                        <tr><td></td><td>$2,000.00</td><td>10 SESIONES</td></tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <div class="box">
        <div class="section-title">Comentarios y/o Sugerencias</div>
        <div style="height: 60px;"></div>
    </div>
    <p class="text-red">PROMOCIÓN DE PAQUETE SOLO VALIDO PAGANDO EN EFECTIVO NO APLICA EN OTRAS PROMOCIONES</p>

                <br><p class="text-black">______________________</p>
                <p class="text-black">Firma de Padre o Tutor</p>
            
    
    <p class="text-black">HE LEÍDO Y ACEPTO LOS TÉRMINOS DEL PRESENTE CONTRATO ADHIRIÉNDOME A LA VOLUNTAD EXPRESADA EN EL MISMO.</p>

    
    <strong>CLÁUSULAS DEL CONTRATO DE ADHESIÓN: </strong><br>
    <div class="footer-legal">
        <strong>COBERTURA DEL SERVICIO MÉDICO:</strong><br>
        Este seguro es para atender las LESIONES AGUDAS que sufra un jugador de la liga. Las lesiones agudas son daños físicos que ocurren de forma repentina y súbita tales como: <br>
        •Traumatismos, caídas o movimientos bruscos, con síntomas inmediatos como dolor intenso, hinchazón y disfunción. Comunes en el deporte. <br>
        •Fracturas, esguinces, desgarres musculares. <br>
        •Heridas a suturar originada por golpes y contusiones en el campo de juego. <br> 
        Las atenciones médicas serán atendidas por una cantidad máxima de atención de $50,000.00 (cincuenta mil pesos 00/100 M.N) por evento y por jugador. <br>  
        COMPROBACION DEL EVENTO <br>
        Lo anterior se comprobará con el calendario de juegos y rol de entrenamientos de la Liga. El incidente de lesión debe suscitarse durante los horarios de entrenamiento o de juego para que pueda considerarse valida.<br> 
        Aplicara únicamente para los equipos que pertenezcan a la liga. <br>
        El reporte de lesión debe realizarse estrictamente en el momento del accidente. Cualquier reporte extemporáneo no podrá ser atendido bajo los lineamientos del seguro.<br>  
        Para hacerse el reporte debe ser de la siguiente manera: <br>
        •Enviar fotografía de la credencial de solicitante <br>
        •Enviar fotografía indicando la zona corporal de la lesión.<br>  
        •Descripción o motivo de la lesión.  <br>
        •Cedula arbitral correspondiente al encuentro (el partido debe ser gestionado de manera oficial por la liga) <br>
        •Ubicación del campo del futbol en el cual ocurrió el accidente. <br>
        Al presentarse para atención medica deberá presentar una copia de la credencial de afiliación a la liga, evidencia en el momento por medio de una foto del jugador lesionado y la cédula arbitral. Y debe ser acompañado de su padre o tutor el cual deberá presentar alguna identificación oficial.<br> 
        NOTA: La evidencia fotográfica si es estricta y obligatoria.  <br>
        El/la contratante deberá proporcionar de manera obligatoria una imagen de la lesión como parte del expediente correspondiente. Dicha imagen será utilizada exclusivamente para fines de verificación y documentación derivados de la presente relación contractual, y en ningún caso será empleada para otros fines distintos a los aquí establecidos. La información será tratada conforme a las disposiciones de confidencialidad y protección de datos aplicables.<br> 
        SERVICIOS MÉDICOS INCLUIDOS  <br>
        a)Consulta de medicina general  <br>
        •Las consultas generales serán a libre demanda 3 horas posterior al evento reportado. INCLUIDA SIN COSTO <br>
        •48 horas máximo después del evento. Con cita $100.00. COSTO PREFERENCIAL. <br>
        •Posterior a estas fechas el costo será de $250.00 COSTO PREFERENCIAL, $300 Costo regular.<br>  
        b)Consulta de especialidad (Traumatología) <br>
        •Consulta SIN COSTO, con previa cita y con referencia médica emitida por el medico general del seguro.<br> 
        •Si el asegurado lo solicita, la consulta de especialidad es de $750.00 COSTO PREFERENCIAL. PREVIA CITA.  <br>
        Las citas con traumatología tendrán hasta 24 hrs para otorgarse. <br>
        COSTO REGULAR DE LA CITA CON TRAUMATOLOGIA $1500.00 <br>
        c)	Rayos X <br>
        •	Estudios de Rayos X simples (SOLO JUGADORES CON SOSPECHA DE FRACTURA). Sin costo.  <br>
        •	Cualquier solicitud de Rayos X para alguno de nuestros asegurados promovida por el padre o tutor que acompañe al menor deberá ser pagada previa a la toma (Costo preferencial $300.00 por toma sea pago en efectivo y/o tarjeta).<br> 
        NOTA: Si al realizar la radiografía se comprueba que el asegurado si tienen una fractura el costo de la misma será bonificado siempre y cuando la toma se haya realizado en nuestra clínica.  <br>
        d)	Hospitalización  <br>
        • Hasta 8 horas de hospitalización en corta estancia indicada por el medico general después de la consulta SIN COSTO. <br>
        e)	Rehabilitación física <br>
        •	Sesiones de terapias de rehabilitación física (SOLO PARA NIÑOS 
        ASEGURADOS CON LESIONES AGUDAS INDICADAS POR EL 
        TRAUMATOLOGO). Aplica restricciones. <br>
        •	Toda lesión que no sea aguda pero que requiera asistir a fisioterapia tendrá su primera consulta gratuita y en las posteriores a un costo preferencial de $300.00 a los miembros de la liga. 
        COSTO DE PAQUETE DE FISIOTERAPIAS ADICIONALES <br>
        •	5 sesiones de fisioterapia: $1,250.00 <br>
        •	10 sesiones de fisioterapia: $2,000.00 <br>
        RESTRICCIONES DE FISIOTERAPIA  <br>
        •	Si compraste un paquete y no asististe por cualquier motivo, aunque llames se pierde la cita y se descuenta de tu servicio adquirido. Debido a que te estamos dando una súper promoción de entre el 50% y 60% de descuento. COSTO AL PUBLICO EN GENERAL $500.00 <br>
        •	Si la lesión es aguda y requieres fisioterapia, están incluidos en tu paquete.  Pero si al agendarte tus citas no asistes, se darán por perdidas las citas. Y en dado caso que requieras más o que el tratamiento quede incompleto será responsabilidad del asegurado pagar las fisioterapias adicionales. <br>
        •	No incluye la atención médica que sea susceptible de utilizar servicios de terapia intensiva o una unidad de choque, estos pacientes deberán dirigirse a otras instituciones médicas.  <br>
        •	Tampoco incluye la atención de padecimientos de enfermedades crónico degenerativas o cualquier enfermedad adquirida con anterioridad prexistente al partido de fútbol o entrenamiento.  <br>
        •	No incluye muletas ni órtesis alguna (dispositivo médico diseñado para soportar, alinear, prevenir o corregir deformidades).  <br>
        REPROGRAMACION DE CITAS <br>
        En caso de no poder asistir a una cita médica (No de rehabilitación) <br>
        Se permitirá una reprogramación sin penalización, siempre que se avise con al menos 4 hrs de anticipación. <br> 
        Precio 2026 costo por jugador $260.00 (doscientos treinta pesos 00/100 M.N.) Asegurado por un año. <br>
        Hospitalidad Health Care regresara un monto de $30.00 por jugador al finalizar el convenio, este retroactivo se regresará en especie para el pago de medallas del torneo que la liga indique. Siempre y cuando se haya hecho un buen uso del servicio del seguro, siga las ofertas del mismo y de las instalaciones.  <br>
        El costo del seguro será de carácter público y el usuario conocerá con claridad el monto de este.<br> 
        <br>
        <strong>RESTRICCIONES:</strong> No incluye atención médica de enfermedades no degenerativas...<br>
    </div>
    <table style="border: none; margin-top: 40px; margin-left: auto; margin-right: auto; width: 250px;">
    <tr style="border: none;">
        <td style="border: none; text-align: center;">
            <div class="signature-line">Firma de enterado</div>
        </td>
    </tr>

</table>
            <p class="text-black">HE LEÍDO Y ACEPTO LOS TÉRMINOS DEL PRESENTE CONTRATO ADHIRIÉNDOME A LA VOLUNTAD EXPRESADA EN EL MISMO.</p>

</body>
</html>