<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Riesgos y Complicaciones en Cirugía</title>
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

        /* Firmas en dos columnas */
        .signature-columns {
            display: flex;
            justify-content: space-between;
            margin-top: 60px;
            page-break-inside: avoid;
        }

        .signature-box {
            width: 48%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 90%;
            margin: 0 auto 5px auto;
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
        <h1>Riesgos y Complicaciones en Cirugía</h1>

        {{-- ENCABEZADO --}}
        <h3>Encabezado</h3>
        <div class="section-content">
            <p>CUERNAVACA, MORELOS. C.P. 62260 TEL: 777 323 0371</p>
            <p>Licencia sanitaria No. 23-AM-17-007-0002</p>
            <p>Responsable Sanitario Dr. Juan Manuel Ahumada Trujillo.</p>
        </div>

        {{-- CUERPO DEL DOCUMENTO --}}
        <h3>Cuerpo del Documento</h3>
        <div class="section-content">
            <p>Con fundamento en la Norma Oficial Mexicana NOM-004-SSA3-2012 del expediente clínico, el presente documento tiene por objeto informar al (la) paciente sobre los riesgos y posibles complicaciones inherentes a los procedimientos quirúrgicos y anestésicos, conforme a la evidencia médica vigente y a la práctica quirúrgica estandarizada.</p>
            <p><strong>Riesgos y Complicaciones Generales de los Procedimientos Quirúrgicos:</strong> Todo procedimiento quirúrgico implica riesgos inherentes, los cuales pueden presentarse durante el acto operatorio o en el periodo postoperatorio inmediato o tardío. Entre los eventos adversos más frecuentemente descritos se incluyen:</p>
            <ul>
                <li>Alteraciones en la cicatrización: formación de cicatriz hipertrófica, atrófica o queloide.</li>
                <li>Dehiscencia de la herida quirúrgica o hernia incisional.</li>
                <li>Formación de colecciones postoperatorias tales como hematoma, seroma o absceso.</li>
                <li>Infección del sitio quirúrgico, tanto superficial como profunda, pudiendo requerir drenaje o reintervención.</li>
                <li>Granulomas o rechazo de material de sutura y/o prótesis (mallas, placas, tornillos).</li>
                <li>Lesión de víscera hueca o sólida, que podría requerir resección intestinal, confección de estomas temporales definitivos, o reparación quirúrgica adicional.</li>
                <li>Formación de fístulas (intestinales, biliares, urinarias o cutáneas).</li>
                <li>Lesión de vía biliar o necesidad de derivación bilio-digestiva.</li>
                <li>Complicaciones biliares postoperatorias (biloma, colecciones infectadas).</li>
                <li>Conversión a cirugía abierta o realización de procedimientos complementarios (colecistectomía subtotal, fundus-first, laparoscopia diagnóstica).</li>
                <li>Uso de catéteres, sondas, drenajes o dispositivos endoluminales según criterio médico.</li>
            </ul>
            <p><strong>Complicaciones Específicas por Tipo de Cirugía:</strong> De acuerdo con el tipo de intervención, pueden presentarse además complicaciones particulares, tales como:</p>
            <ul>
                <li>Lesión de estructuras vasculares, nerviosas o musculares.</li>
                <li>Hemorragias de diversa magnitud, que pueden requerir transfusión de sangre o hemoderivados.</li>
                <li>Infección o absceso intraabdominal o intratorácico.</li>
                <li>Trombosis venosa profunda (TVP), embolia pulmonar o eventos tromboembólicos.</li>
                <li>Compromiso inmunológico en cirugías oncológicas extensas o con tratamiento adyuvante.</li>
                <li>Complicaciones anestésicas: reacciones adversas a medicamentos, dificultad de intubación, broncoaspiración o paro cardiorrespiratorio.</li>
                <li>Síndrome postoperatorio específico según el procedimiento (p. ej. pancreatitis post-CPRE, síndrome post-RTUP, endometritis, perforación uterina, etc.).</li>
            </ul>
            <p><strong>Riesgos Críticos y Complicaciones Graves Potenciales:</strong> Durante o posterior al procedimiento quirúrgico pueden presentarse complicaciones mayores que pongan en riesgo la vida del paciente, tales como:</p>
            <ul>
                <li>Hemorragia masiva o choque hipovolémico.</li>
                <li>Sepsis o choque séptico.</li>
                <li>Choque anafiláctico por reacción medicamentosa.</li>
                <li>Lesiones neurológicas o complicaciones cerebrovasculares.</li>
                <li>Intubación prolongada y/o necesidad de manejo en terapia intensiva.</li>
                <li>Paro cardiorrespiratorio, necesidad de reanimación cardiopulmonar básica o avanzada, uso de aminas vasoactivas, cardioversión eléctrica o desfibrilación.</li>
                <li>Fallecimiento en etapa preoperatoria, transoperatoria o postoperatoria.</li>
            </ul>
            <p><strong>Declaración del Paciente</strong></p>
            <p>Declaro haber recibido información suficiente, clara y comprensible respecto a los riesgos, beneficios y posibles complicaciones del procedimiento quirúrgico al que seré sometido (a), así como de las alternativas terapéuticas disponibles.</p>
            <p>Se me ha brindado la oportunidad de realizar preguntas, mismas que fueron respondidas satisfactoriamente. Comprendo que, aunque el equipo médico tomará todas las medidas de seguridad y asepsia necesarias, ningún procedimiento quirúrgico está exento de riesgos o complicaciones.</p>
            <p>En virtud de lo anterior doy mi consentimiento por escrito para los médicos cirujanos de Hospitalidad Health Care lleven los procedimientos que consideren necesarios o procedimientos médicos al que he decidido someterme por motivo “urgencia o programación”, en el entendimiento que si ocurren complicaciones en la aplicación de la técnica quirúrgica no exista conducta dolosa.</p>
        </div>

        

        {{-- SECCIÓN DE FIRMAS PACIENTE / TUTOR EN DOS COLUMNAS --}}
        <div class="signature-columns">
            {{-- Columna izquierda: Paciente --}}
            <div class="signature-box">
                <div class="signature-line"></div>
                <p>{{ $paciente->nombre ?? 'Sin datos.' }}</p>
                <p style="font-size: 9pt; color: #555;">Nombre y firma del paciente</p>
            </div>

            {{-- Columna derecha: Familiar o Tutor --}}
            <div class="signature-box">
                <div class="signature-line"></div>
                <p>Familiar o Tutor Legal</p>
                <p style="font-size: 9pt; color: #555;">Nombre y firma del familiar o tutor</p>
            </div>
        </div>

        {{-- SECCIÓN DE FIRMA DEL MÉDICO EN DOS COLUMNAS (MÉDICO + ESPACIO) --}}
        @if(isset($medico))
            <div class="signature-columns" style="margin-top: 40px;">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno }}</p>
                    <p style="font-size: 9pt; color: #555;">Nombre y firma del médico</p>

                    @if($medico->credenciales->isNotEmpty())
                        <div class="credentials-list">
                            @foreach($medico->credenciales as $credencial)
                                <p>
                                    <strong>Título:</strong> {{ $credencial->titulo }}
                                    &nbsp;|&nbsp;
                                    <strong>Cédula Profesional:</strong> {{ $credencial->cedula_profesional }}
                                </p>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="signature-box">
                    <!-- Espacio disponible (sello, segunda firma, etc.) -->
                </div>
            </div>
        @endif
    </main>
</body>
</html>
