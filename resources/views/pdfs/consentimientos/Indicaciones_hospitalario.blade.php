<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Indicaciones para el Ingreso Hospitalario</title>
    <style>
        @page {
            size: A4;
            margin-top: 5cm;
            margin-bottom: 1.5cm;
            margin-left: 1.2cm;
            margin-right: 1.2cm;
            @bottom-right {
                content: "Página " counter(page) " de " counter(pages);
                font-family: Calibri, Arial, sans-serif;
                font-size: 9pt;
                color: #888;
            }
        }
        * { box-sizing: border-box; }
        body {
            font-family: Calibri, Arial, sans-serif;
            margin: 0;
            font-size: 10.5pt;
            color: #333;
            line-height: 1.4;
        }
        h1 {
            text-align: center;
            font-size: 16pt;
            margin-bottom: 20px;
            color: #2c3e50;
            text-transform: uppercase;
        }
        h3 {
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            font-size: 12pt;
            color: #2c3e50;
            page-break-after: avoid;
        }
        .section-content { padding-left: 5px; margin-bottom: 15px; }
        ul { margin: 0 0 10px 20px; padding: 0; }
        li { margin-bottom: 5px; }
        .important { font-weight: bold; }
        .no-portable { color: #c0392b; font-weight: bold; }
        .table-signatures {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .table-signatures td {
            width: 50%;
            vertical-align: top;
            text-align: center;
            padding: 10px;
        }
        .signature-line {
            width: 80%;
            height: 1px;
            background-color: #000;
            margin: 40px auto 5px auto;
        }
    </style>
</head>
<body>
    <main>
        <h1>Indicaciones para el Ingreso Hospitalario y Procedimiento Quirúrgico</h1>

        <h3>Previo a la cirugía</h3>
        <div class="section-content">
            <ul>
                <li>Presentarse <span class="important">1 hora y media antes</span> de la hora programada para la cirugía.</li>
                <li>Contar con el <span class="important">nombre del médico</span> que realizará el procedimiento.</li>
                <li>Solo se permitirá el ingreso de un <span class="important">familiar responsable</span>. Los demás deberán esperar en la sala de espera.</li>
                <li><span class="important">Despúes de la cirugía</span> se permitirá el accesos a visitas de acuerdo al reglamento de hospital<span class="important">(máximo 2 personas por habitación</span> en horarios de visita).</li>
                <li>Mantener <span class="important">ayuno de 8 horas</span> antes del procedimiento.</li>
                <li><span class="important">Conocer los cuidados y requisitos previos</span> al procedimiento quirúrgico.</li>
            </ul>
        </div>

        <h3>Al momento de su llegada, debe llevar consigo los siguientes requisitos:</h3>
        <div class="section-content">
            <ul>
                <li><span class="important"> Identificación oficial con fotografía </span>(INE, pasaporte o licencia) tanto del paciente como del familiar responsable.</li>
                <li>Ropa cómoda y artículos de higiene personal.</li>
                <li><span class="important">Estudios clínicos </span>(original o copia) como análisi de laboratorio o rayos X solicitados por el médico o <span class="important">necesarios ára conocer su historial clínico</li>
                <li>Contar con una <span class="name">orden de internamiento</span> que incluya las indiciacciones de preparación para la cirugía, firmada y con nombre del médico tratante o cirjuano, responsable del procedimiento. </li>
            </ul>
        </div>

        <h3>Durante el proceso de Admisión e Ingreso</h3>
        <div class="section-content">
            <ul>
                <li> Seguir siempre las indicaciones del personal médico y de enfermería para la seguridad y bienestar </li>
            <p class="no-portable">X NO deberá portar:</p>
            
                <li>Aretes, cadenas, anillos u objetos de valor.</li>
                <li>Uñas con esmalte o acrílico.</li>
                <li>Placas dentales.</li>
            </ul>
        </div>

        <table class="table-signatures">
            <tr>
                <td>
                    <div class="signature-line"></div>
                    <p>{{ $paciente->nombre_completo ?? 'Sin datos.' }}</p>
                    <p style="font-size: 9pt; color: #555;">Firma del Paciente</p>
                </td>
                <td>
                    <div class="signature-line"></div>
                    <p>{{ $estancia->familiarResponsable->nombre ?? 'Sin datos.' }}</p>
                    <p style="font-size: 9pt; color: #555;">Firma del Familiar Responsable</p>
                </td>
            </tr>
        </table>
    </main>
</body>
</html>


<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reglamento para Pacientes y Acompañantes</title>
    <style>
        /* Se mantienen los estilos del documento anterior para consistencia */
        @page { size: A4; margin: 5cm 1.2cm 1.5cm 1.2cm; }
        body { font-family: Calibri, Arial, sans-serif; font-size: 10pt; line-height: 1.3; color: #333; }
        h1 { text-align: center; font-size: 16pt; text-transform: uppercase; margin-bottom: 10px; }
        h3 { border-bottom: 1px solid #ccc; font-size: 11pt; margin-top: 12px; color: #2c3e50; }
        ul { margin-bottom: 8px; }
        li { margin-bottom: 3px; }
        .schedule { text-align: center; font-weight: bold; background: #f9f9f9; padding: 5px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <main>
        <h1>Reglamento para Pacientes y Acompañantes</h1>
        
        <div class="schedule">
            Horario de visita: 10:00 a 13:00 hrs. Y de 16:00 a 19:00 hrs.
           
        </div>
         <p>En <span class="important"> Hospitalidad Health Care</span> estamos comprometidos con su
            salud, y por eso constantemente nos encontramos mejorando nuestros servicios 
            para ofrecerle lo mejor. En la mayor de los casos, las visitas de amigos y familiares
             son bienvenidas y contribuyen a la recuperación del paciente</p>
        <p> Por favor revisen nuestros horarios y reglamentos internos</p>
        <h3>Normas de Estancia y Visitas</h3>
        <div class="section-content">
            <ul>
                <li>Por seguridad de todos los usuarios del hospital, en la recepción le pedirá que se indentifique al acceder a las instalaciones.</li>
                <li>Silencio. Es conveniente mantener el silencio en la medida de lo posible y limitar el número de acompañantes. Moderar el tono de voz y de cualquiermedio audiovisual ayuda a respetar el descanso de los pacientes.</li>
                <li>Se pide sean respetados los señalamientos internos, así como <span class="important"> guardar silencio</span> en las salas de espera, pasillos y habitaciones</li>

                <li>Se permite un máximo de <span style="font-weight:bold">2 visitantes</span> a la vez por habitación.</li>
                <li>Quedan prohibidas las visitas de <span style="font-weight:bold">menores de 12 años</span> de edad.</li>
                <li>Solo podrá pernoctar un acompañante por cuarto.</li>
                <li>Es obligatorio mantener el silencio en pasillos y habitaciones.</li>
                <li>Las puertas de las habitaciones deben permanecer cerradas por seguridad.</li>
            </ul>
        </div>

        <h3>Restricciones Importantes</h3>
        <div class="section-content">
            <ul>
                <li>Está estrictamente prohibido introducir alimentos ajenos a la dieta hospitalaria.</li>
                <li>Prohibido fumar o ingerir bebidas alcohólicas dentro de las instalaciones.</li>
                <li>No se permite introducir peluches, mascotas, globos de helio o arreglos florales/frutales.</li>
                <li>El uso de la ducha es exclusivo para el paciente; familiares y visitas no deberán bañarse en la habitación.</li>
            </ul>
        </div>

        <h3>Responsabilidades</h3>
        <div class="section-content">
            <p>El hospital no se hace responsable por la pérdida de objetos de valor. Se recomienda no traer alhajas ni grandes sumas de dinero.</p>
            <p>Al finalizar su estancia, favor de recoger todos sus estudios clínicos originales antes del egreso.</p>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <p>He leído y acepto el reglamento de la institución:</p>
            <div style="width: 300px; border-top: 1px solid #000; margin: 40px auto 5px auto;"></div>
            <p>{{ $paciente->nombre_completo ?? 'Nombre del Paciente / Responsable' }}</p>
        </div>
    </main>
</body>
</html>