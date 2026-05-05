<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Verificación de Cirugía Segura</title>
    <style>
        @page {
            size: A4;
            margin-top: 5.5cm;
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
            font-size: 16pt;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        h3 {
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            font-size: 11pt;
            color: #000;
            page-break-after: avoid;
            text-transform: uppercase;
        }

        p {
            margin: 0 0 6px 0;
        }

        .section-content {
            padding-left: 5px;
            margin-bottom: 15px;
        }

        .check-item {
            margin-bottom: 4px;
        }

        .bold {
            font-weight: bold;
        }

        /* Estilo para las respuestas SI/NO */
        .status {
            font-weight: bold;
            color: #000;
            text-decoration: underline;
        }
        .signature-grid {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-box {
            width: 48%; 
            display: inline-block;
            vertical-align: top;
            margin-bottom: 40px;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 80%;
            margin: 0 auto 5px auto;
        }

        .signature-label {
            font-size: 8pt;
            color: #555;
            margin-bottom: 5px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .signature-section {
            text-align: center;
            margin-top: 50px; 
            page-break-inside: avoid; 
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 280px; 
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
        <h1>Lista de Verificación de Cirugía Segura</h1>

        {{-- SECCIÓN 1: DATOS QUIRÚRGICOS --}}
        <div class="section-content">
            <p>
                <strong>Servicio de procedencia:</strong> {{ $notaData->servicio_procedencia ?? 'N/A' }} | 
                <strong>Grupo sanguíneo y RH:</strong> {{ $notaData->grupo_rh ?? 'N/A' }}
            </p>
            <p><strong>Cirugía programada:</strong> {{ $notaData->cirugia_programada ?? 'N/A' }}</p>
            <p><strong>Cirugía realizada:</strong> {{ $notaData->cirugia_realizada ?? 'N/A' }}</p>
        </div>

        {{-- SECCIÓN 2: ENTRADA --}}
        <h3>Al ingresar paciente a sala, antes (Personal de enfermería, anestesiólogo y cirujano) </h3>
        <div class="section-content">
            <p class="check-item">¿Confirmación de identidad, sitio quirúrgico, procedimiento y ayuno?: <span class="status">{{ $notaData->confirmar_indentidad ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">¿Se marcó el sitio quirúrgico?: <span class="status">{{ $notaData->sitio_quirurgico ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">¿Funcionamiento de aparatos de anestesia y medicamentos?: <span class="status">{{ $notaData->funcionamiento_aparatos ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">¿Oxímetro de pulso colocado y funciona?: <span class="status">{{ $notaData->oximetro ? 'SÍ' : 'NO' }}</span></p>
            <p><strong>Alergias conocidas:</strong> {{ $notaData->alergias ?: 'Ninguna' }}</p>
            <p class="check-item">¿Vía aérea difícil y/o riesgo de aspiración?: <span class="status">{{ $notaData->via_aerea ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">¿Riesgo de hemorragia (>500ml): <span class="status">{{ $notaData->riesgo_hemorragia ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">¿Disponibilidad de hemoderivados y soluciones?: <span class="status">{{ $notaData->hemoderivados ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">¿Administración de profilaxis antibiótica?: <span class="status">{{ $notaData->profilaxis ? 'SÍ' : 'NO' }}</span></p>
        </div>

        {{-- SECCIÓN 3: PAUSA --}}
        <h3>Antes se incidir piel (Personal de enfermería, anestesiólogo y cirujano)</h3>
        <div class="section-content">
            <p class="check-item">Presentación de los miembros del equipo por nombre y función: <span class="status">{{ $notaData->miembros_equipo ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">Confirmación de identidad del paciente, sitio y procedimiento: <span class="status">{{ $notaData->indentidad_paciente ? 'SÍ' : 'NO' }}</span></p>
            <p><strong>Pasos críticos o no sistematizados:</strong> {{ $notaData->pasos_criticos ?: 'Ninguno' }}</p>
            <p><strong>Tiempo aproximado de cirugía:</strong> {{ $notaData->tiempo_aproximado }} min | <strong>Pérdida sanguínea prevista:</strong> {{ $notaData->perdida_sanguinea }} ml</p>
            <p class="check-item">¿Anestesiólogo revisa morbilidades?: <span class="status">{{ $notaData->revision_anestesiologo ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">¿Esterilización de instrumental y ropa confirmada?: <span class="status">{{ $notaData->esterilizacion ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">¿Visualización de imágenes diagnósticas esenciales?: <span class="status">{{ $notaData->imagenes_diagnosticas ? 'SÍ' : 'NO' }}</span></p>
        </div>

        {{-- SECCIÓN 4: SALIDA --}}
        <h3>Antes de que el paciente salga de la sala quirúrgica (Personal de enfermería, anestesiólogo y cirujano)</h3>
        <div class="section-content">
            <p class="check-item">Confirmación verbal del nombre del procedimiento: <span class="status">{{ $notaData->nombre_procedimiento ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">Recuento de instrumentos, agujas y textiles completos: <span class="status">{{ $notaData->recuento_instrumentos ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">¿Existen faltantes de instrumentos y/o textiles?: <span class="status">{{ $notaData->faltantes ? 'SÍ' : 'NO' }}</span></p>
            <p class="check-item">Etiquetado de muestras en voz alta: <span class="status">{{ $notaData->etiquetado_muestras ? 'SÍ' : 'NO' }}</span></p>
            <p><strong>Observaciones:</strong> {{ $notaData->observaciones ?: 'Sin observaciones.' }}</p>
            <p><strong>Aspectos críticos de recuperación postoperatoria:</strong> {{ $notaData->aspectos_criticos ?: 'Sin datos.' }}</p>
        </div>

        <div class="signature-grid">
            
            <div class="signature-box">
                
                <div style="height: 60px;"></div> <div class="signature-line"></div>
                <div class="signature-label">Cirujano</div>
                @if(isset($medico))
                    @php $firmante = $medico->colaborador_responsable ?? $medico; @endphp
                    <p class="bold" style="font-size: 9pt; margin:0;">
                        {{ $firmante->nombre_completo ?? $firmante->name }}
                    </p>
                    @if(isset($firmante->credenciales) && $firmante->credenciales->isNotEmpty())
                        <p style="font-size: 7pt; color: #555; margin:0;">
                            Cédula: {{ $firmante->credenciales->first()->cedula_profesional }}
                        </p>
                    @endif
                @else
                    <p style="font-size: 8pt; color: #ccc;">Nombre y Firma</p>
                @endif
                
            </div>

            <div class="signature-box">
                <div style="height: 60px;"></div>
                <div class="signature-line"></div>
                <div class="signature-label">Anestesiólogo</div>
                <p style="font-size: 8pt; color: #ccc;">Nombre y Firma</p>
            </div>

            <div class="signature-box">
                <div style="height: 60px;"></div>
                <div class="signature-line"></div>
                <div class="signature-label">Enf. Instrumentista</div>
                <p style="font-size: 8pt; color: #ccc;">Nombre y Firma</p>
            </div>

            <div class="signature-box">
                <div style="height: 60px;"></div>
                <div class="signature-line"></div>
                <div class="signature-label">Enf. Circulante / Verificador</div>
                <p style="font-size: 8pt; color: #ccc;">Nombre y Firma</p>
            </div>

        </div>
    </main>
</body>
</html>