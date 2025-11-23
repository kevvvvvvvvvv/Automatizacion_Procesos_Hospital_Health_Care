<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Declaración de Consentimiento Bajo Información por Anestesia</title>
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

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Calibri, Arial, sans-serif; 
            margin: 0; 
            font-size: 10.5pt; 
            color: #333;
            line-height: 1.4;
        }

        h1 {
            text-align: center;
            font-size: 18pt;
            margin-bottom: 20px;
        }

        h3 {
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            font-size: 12pt;
            page-break-after: avoid;
        }

        p {
            margin: 0 0 8px 0;
        }

        .section-content {
            padding-left: 5px;
        }

        .signature-section {
            text-align: center;
            margin-top: 60px; 
            page-break-inside: avoid; 
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 280px; 
            margin: 0 auto 5px auto; 
        }
        .signature-section p {
            margin: 0;
            line-height: 1.4;
        }
        .credentials-list {
            font-size: 8pt; 
            color: #555;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <main>
        <h1>Declaración de Consentimiento Bajo Información por Anestesia</h1>

        {{-- ENCABEZADO --}}
        <h3>Encabezado</h3>
        <div class="section-content">
            <p>CUERNAVACA, MORELOS. C.P. 62260 TEL: 777 323 0371</p>
            <p>Licencia sanitaria No. 23-AM-17-007-0002</p>
            <p>Responsable Sanitario Dr. Juan Manuel Ahumada Trujillo.</p>
        </div>

        {{-- CAMPOS ESPECÍFICOS --}}
        <h3>Campos Específicos</h3>
        <div class="section-content">
            <p>Familiar Responsable y/o Representante legal: {{ $paciente->familiar_responsable ?? 'Sin datos.' }}</p>
            <p>Diagnóstico Preoperatorio: {{ $paciente->diagnostico_preoperatorio ?? 'Sin datos.' }}</p>
            <p>Cirugía Programada: {{ $paciente->cirugia_programada ?? 'Sin datos.' }} Carácter de la Cirugía o Procedimiento: Electiva: {{ $paciente->caracter_cirugia == 'Electiva' ? 'X' : '' }} o Urgente: {{ $paciente->caracter_cirugia == 'Urgente' ? 'X' : '' }}</p>
        </div>

        {{-- CUERPO DEL CONSENTIMIENTO --}}
        <h3>Cuerpo del Consentimiento</h3>
        <div class="section-content">
            <p>De acuerdo a la Norma Oficial Mexicana NOM-168-SSA1-1998 del expediente clínico médico, publicado el Lunes 14 de Diciembre de 1998, en su capítulo 10.1.1.2.3 y la Norma Oficial Mexicana NOM-170-SSA1-1998 de la práctica de la anestesiología, publicado en el diario oficial de la federación el 14 de Diciembre de 1998, expresado en los capítulos 4.12 y 16.1.1 es presentado este documento escrito y signado por el paciente y/o representante legal, así como por dos testigos, mediante el cual, acepta bajo la debida información los riesgos y los beneficios esperados del procedimiento anestésico. Esta carta se sujetará a las disposiciones sanitarias en vigor y no obliga al médico a realizar u omitir procedimientos cuando ello entrañe un riesgo injustificado para el paciente.</p>
            <p>Por consiguiente y en Calidad de Paciente DECLARO:</p>
            <p>1. Que cuento con la información suficiente sobre los riesgos y beneficios durante mi procedimiento anestésico, y que puede cambiar de acuerdo a mis condiciones físicas y lo emocionales, o lo inherente al procedimiento quirúrgico</p>
            <p>2. Que todo acto médico implica una serie de riesgos debido a mi estado físico actual, mis antecedentes, tratamientos previos y a la causa que da origen a la intervención quirúrgica, procedimientos de diagnóstico y tratamiento o una combinación de ambos factores.</p>
            <p>3. Que existe la posibilidad de complicaciones leves hasta severas, pudiendo causar secuelas permanentes e incluso complicaciones que lleven al fallecimiento.</p>
            <p>4. Que puedo requerir de tratamientos complementarios que aumenten mi estancia hospitalaria con la participación de otros servicios o unidades médicas.</p>
            <p>5. Que existe la posibilidad de que mi procedimiento anestésico se retrase e incluso se suspenda por causas propias a la dinámica del procedimiento anestésico o causas de fuerza mayor (Urgencias).</p>
            <p>6. Que se me ha informado que el personal médico de este servicio, cuenta con amplia experiencia, con equipo médico para mi cuidado y manejo durante el procedimiento y aun así no me exime de presentar complicaciones.</p>
            <p>7. Que soy responsable de comunicar mi decisión y lo antes informado a mi familia.</p>
            <p>En virtud de lo anterior, doy mi consentimiento por escrito para que los médicos anestesiólogos de Clínica Borda SA de CV l leven los procedimientos que consideren necesarios para realizar la anestesia o procedimientos médicos al que he decidido someterme, en el entendimiento que si ocurren complicaciones en la aplicación de la técnica anestésica, no existe conducta dolosa.</p>
        </div>

       

        {{-- SECCIÓN DE FIRMAS --}}
        <div class="signature-section">
            <div class="signature-line"></div>
            <p>{{ $paciente->nombre ?? 'Sin datos.' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y firma Paciente y/o Familiar responsable</p>
            <div class="signature-line"></div>
            <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno ?? 'Sin datos.' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre, firma y cédula profesional Médico anestesiólogo</p>
            <div class="signature-line"></div>
            <p>{{ $medico_tratante->nombre . " " . $medico_tratante->apellido_paterno . " " . $medico_tratante->apellido_materno ?? 'Sin datos.' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre, firma y cédula profesional Médico tratante</p>
        </div>

        {{-- SECCIÓN DE FIRMA DEL MÉDICO (si aplica) --}}
        @if(isset($medico))
            <div class="signature-section">
                <div class="signature-line"></div>
                <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno}}</p>
                <p style="font-size: 9pt; color: #555;">Nombre y Firma del Médico</p>

                @if($medico->credenciales->isNotEmpty())
                    <div class="credentials-list">
                        @foreach($medico->credenciales as $credencial)
                            <p>
                                <strong>Título:</strong> {{ $credencial->titulo }} | <strong>Cédula Profesional:</strong> {{ $credencial->cedula_profesional }}
                            </p>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif  
    </main>
</body>
</html>
