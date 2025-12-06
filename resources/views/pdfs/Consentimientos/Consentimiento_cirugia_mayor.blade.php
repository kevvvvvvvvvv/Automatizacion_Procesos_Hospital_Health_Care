<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consentimiento Médico Informado Quirúrgico</title>
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
        <h1>Consentimiento Médico Informado Quirúrgico</h1>

        {{-- ENCABEZADO --}}
        <h3>Encabezado</h3>
        <div class="section-content">
            <p>CUERNAVACA, MORELOS. C.P. 62260 TEL: 777 323 0371</p>
            <p>Licencia sanitaria No. 23-AM-17-007-0002</p>
            <p>Responsable Sanitario Dr. Juan Manuel Ahumada Trujillo.</p>
        </div>

        {{-- CUERPO DEL CONSENTIMIENTO --}}
        <h3>Cuerpo del Consentimiento</h3>
        <div class="section-content">
            <p>Yo, {{ $paciente->nombre ?? 'Sin datos.' }}, de {{ $paciente->edad ?? 'Sin datos.' }} años de edad, con domicilio en {{ $paciente->domicilio ?? 'Sin datos.' }}, de estado civil {{ $paciente->estado_civil ?? 'Sin datos.' }} (hijo de {{ $paciente->padre ?? 'Sin datos.' }} y {{ $paciente->madre ?? 'Sin datos.' }}), por medio del presente documento:</p>
            <p>Hago constar:</p>
            <p>Que el Dr. {{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno ?? 'Sin datos.' }} especialista en {{ $medico->especialidad ?? 'Sin datos.' }} debidamente acreditado, con consulta en Hospitalidad Health Care Suites Reforma, de la Ciudad de Cuernavaca, Morelos, me ha informado personalmente, a mi completa satisfacción y de forma enteramente comprensible para mí, incluso con apoyo gráfico y contestando a mi satisfacción a las preguntas que le formulé, los motivos por los cuales ha indicado la realización de un procedimiento quirúrgico consistente en ___________________________________________________________, así como me ha informado de las alternativas, los riesgos siguientes: ____________________________________________________________ _______________________________________________________________________________________________ _______________________________________________________, y las posibles complicaciones, entre las cuales puede haber: _______________________________________________________________ _______________________________________________________________________________________, asi como las consecuencias y beneficios inherentes a la operación a realizar.</p>
            <p>Atendiendo por tanto a la prescripción del Dr. {{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno ?? 'Sin datos.' }} y en uso de mi libre voluntad, por medio de este documento, informada y expresamente autorizo, a que se me realice dicha intervención por el Dr. {{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno ?? 'Sin datos.' }} y su equipo quirúrgico.</p>
            <p>De igual manera consiento que a tal propósito y durante el tiempo necesario o conveniente se me interne en Hospitalidad Health Care suites Reforma, ubicado en Plan de Ayutla 13, Col. Reforma, C.P. 62260, Cuernavaca, Morelos.</p>
            <p>Si durante el curso de la intervención y por contingencias no previstas en el momento de esta, se considerase necesario o conveniente para mi salud y recuperación, aplicar procedimientos o medidas terapéuticas adicionales, realizar cualquier otra intervención o manipulación complementaria, incluyendo el uso de sangre y sus derivados, desde luego, expresamente autorizo y consiento que se haga, sin necesidad de revertirme del estado anestésico en que pudiera encontrarme.</p>
        </div>

       

        {{-- CONTINUACIÓN DEL CONSENTIMIENTO --}}
        <h3>Continuación del Consentimiento</h3>
        <div class="section-content">
            <p>Con fines educativos o bien para contribuir al conocimiento científico, también acepto que se filme o se fotografíe el área anatómica tratada en el curso de este procedimiento, resguardando mi identidad.</p>
            <p>Estoy enterado que habré de requerir vigilancia y control postoperatorios hasta mi total recuperación, debiendo para ello seguir de forma precisa las indicaciones de mi médico tratante.</p>
            <p>Quedo en el entendido de que en todo momento habrá de mediar una comunicación expedita y una relación respetuosa con mi médico tratante a quien voluntariamente he acudido en busca de ayuda profesional. Autorizó al personal de salud para la atención de contingencias y urgencias derivadas del acto autorizado.</p>
            <p>La anulación o cancelación de estos consentimientos prestados, deberá constar necesariamente por escrito, firmado personalmente por mí y deberá ser personalmente recibida por los facultativos afectados antes de producirse el acto médico quirúrgico.</p>
            <p>De encontrarme en un momento dado incapacitado para consentir o modificar mi consentimiento, delego todas mis facultades en _________________________________________________________________________.</p>
            <p>Habiendo leído por mí mismo este documento, siendo su contenido perfectamente entendible para mí, y enterado de que los médicos antes mencionados se comprometen a la máxima diligencia en la prestación de los servicios profesionales al nivel tecnológico actual, sin que puedan por otra parte, garantizar absolutamente el resultado, firmo al calce en la ciudad de Cuernavaca, Morelos, a _______ del mes _______ de del año _______.</p>
        </div>

        {{-- SECCIÓN DE FIRMAS --}}
        <div class="signature-section">
            <div class="signature-line"></div>
            <p>{{ $paciente->nombre ?? 'Sin datos.' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y firma del paciente</p>
            <div class="signature-line"></div>
            <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno ?? 'Sin datos.' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y firma del médico</p>
            <div class="signature-line"></div>
            <p>Nombre y firma del familiar o representante legal</p>
            <div class="signature-line"></div>
            <p>Nombre y firma de testigo</p>
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
