<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expediente clínico - Historia clínica</title>
    <style>
        @page {
            size: A4;
            margin: 1.5cm; 
        }

        body {
            font-family: Calibri, Arial, sans-serif; 
            margin: 0; 
            font-size: 10pt; 
            color: #333;
        }

        .header {
            display: flex; 
            justify-content: space-between;
            align-items: center; 
            border-bottom: 1px solid #555; 
            padding-bottom: 8px;
            margin-bottom: 15px; 
        }

        .header .logo {
            width: 150px; 
            margin-right: 15px; 
        }

        .header .hospital-info { 
             text-align: left; 
             font-size: 8pt; 
             line-height: 1.2;
             max-width: 180px; 
        }
        .header .hospital-info p {
             margin: 0;
        }

        .identification-card {
            border: 1px solid #666; 
            padding: 8px 12px; 
            font-size: 9pt; 
            width: 50%;
            flex-grow: 1; 
        }
        
        .identification-card h2 {
            text-align: center;
            font-size: 10pt;
            margin: 0 0 8px 0;
            font-weight: bold;
        }

        .id-row {
            display: flex;
            justify-content: space-between; 
            margin-bottom: 4px; 
            align-items: baseline; 
        }

        .id-field {
            display: flex;
            align-items: baseline;
            margin-right: 7px;
        }
        .id-field:last-child {
            margin-right: 0;
        }

        .id-label {
            font-weight: bold;
            margin-right: 5px;
            white-space: nowrap; 
        }

        .id-value {
            border-bottom: 1px solid #333;
            flex-grow: 1; 
            min-width: 50px; 
        }
        .id-value.long {
             min-width: 200px; 
        }
        .id-value.short {
             min-width: 30px; 
             flex-grow: 0; 
             width: 50px; 
        }

        h1{
            text-align: center;
            align-items:center;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <header class="header">
        <div>
            <img src="{{ public_path('images/Logo_HC_1.png') }}" alt="Logo Hospital" class="logo">
             <div class="hospital-info">
                <p><strong>PLAN DE AYUTLA 413 COL. REFORMA</strong></p>
                <p><strong> CUERNAVACA, MORELOS, C.P. 62260 TEL: 777 323 0371</strong></p>
                <p>Licencia sanitaria No. 23-AM-17-007-0002</p>
                <p>Responsable Sanitario Dr. Juan Manuel Ahumada Trujillo.</p>
            </div>
        </div>

        <div class="identification-card">
            <h2>FICHA DE IDENTIFICACIÓN</h2>
            <div class="id-row">
                <div class="id-field">
                    <span class="id-label">Fecha:</span>
                    <span class="id-value">{{ $historiaclinica->formularioInstancia['fecha_hora'] }}</span> 
                </div>
                </div>
            <div class="id-row">
                 <div class="id-field" style="flex-grow: 1;"> 
                    <span class="id-label">Nombre:</span>
                    <span class="id-value long">{{ $paciente['nombre'] . " " .  $paciente['apellido_paterno'] . " " . $paciente['apellido_materno']}}</span>
                 </div>
            </div>
             <div class="id-row">
                 <div class="id-field">
                    <span class="id-label">Fecha de nacimiento:</span>
                    <span class="id-value">{{ \Carbon\Carbon::parse($paciente['fecha_nacimiento'])->format('Y-m-d') }}</span>
                 </div>
                 <div class="id-field">
                    <span class="id-label">Edad:</span>
                    <span class="id-value short">{{$paciente['age'] . " años"}}</span>
                 </div>
                  <div class="id-field">
                    <span class="id-label">Sexo:</span>
                    <span class="id-value short">{{$paciente['sexo']}}</span>
                 </div>
            </div>
            <div class="id-row">
                <div class="id-field" style="flex-grow: 1;">
                    <span class="id-label">Domicilio:</span>
                    <span class="id-value long"><span class="id-value long">{{ $paciente['calle'] }} {{ $paciente['numero_exterior'] }}{{ $paciente['numero_interior'] ? ' Int. ' . $paciente['numero_interior'] : '' }}, {{ $paciente['colonia'] }}, {{ $paciente['municipio'] }}, {{ $paciente['estado'] }}, {{ $paciente['pais'] }}, C.P. {{ $paciente['cp'] }}</span></span>
                </div>
            </div>
        </div>
    </header>

    <main>
        <h1>HISTORIA CLÍNICA</h1>
@foreach ($preguntasPorCategoria as $categoria => $preguntasDeCategoria)
        
        {{-- Variable para acumular las preguntas respondidas con "No" o sin respuesta --}}
        @php $preguntasSinNovedad = []; @endphp
        
        {{-- Título de la Sección --}}
        <h3 style="margin-top: 15px; margin-bottom: 5px; border-bottom: 1px solid #ccc; padding-bottom: 3px;">
            {{-- Convierte el nombre de la categoría a un formato legible --}}
            {{ ucwords(str_replace('_', ' ', $categoria)) }} 
        </h3>

        {{-- Itera sobre cada pregunta DENTRO de la categoría actual --}}
        @foreach ($preguntasDeCategoria as $pregunta)
            @php
                // Busca la respuesta correspondiente a esta pregunta en el mapa
                $respuesta = $respuestasMap->get($pregunta->id);
                // Extrae el valor de la respuesta principal ('si', 'no', 'Conozco', etc.)
                $valorRespuesta = $respuesta ? ($respuesta->detalles['respuesta'] ?? null) : null;
                // Asume que las opciones personalizadas vienen como array (asegúrate que el cast esté en el modelo CatalogoPregunta)
                $opcionesRespuesta = $pregunta->opciones_respuesta ?? null; 
                
                // Determina si la respuesta es "afirmativa" (requiere mostrar detalles)
                $esAfirmativa = false;
                if ($valorRespuesta) {
                    if ($opcionesRespuesta) {
                        // Si hay opciones personalizadas, busca la seleccionada y mira su flag 'triggersFields'
                        $opcionSeleccionada = collect($opcionesRespuesta)->firstWhere('value', $valorRespuesta);
                        if ($opcionSeleccionada && ($opcionSeleccionada['triggersFields'] ?? false)) {
                            $esAfirmativa = true;
                        }
                    } elseif ($valorRespuesta === 'si') {
                        // Si no hay opciones personalizadas, usa la lógica de 'si'
                        $esAfirmativa = true;
                    }
                }
            @endphp

            {{-- Si la respuesta fue afirmativa, muestra la pregunta subrayada y los detalles --}}
            @if ($esAfirmativa)
                <div style="margin-bottom: 5px;">
                    <strong style="text-decoration: underline;">{{ $pregunta->pregunta }}:</strong> 

                    {{-- Lógica para mostrar los detalles según el tipo de pregunta --}}
                    @if ($pregunta->tipo_pregunta === 'simple' && isset($respuesta->detalles['campos']['detalle']))
                        {{ $respuesta->detalles['campos']['detalle'] }}

                    @elseif (($pregunta->tipo_pregunta === 'multiple_campos' || $pregunta->tipo_pregunta === 'direct_select' || $pregunta->tipo_pregunta === 'direct_multiple') && isset($respuesta->detalles['campos']))
                        @php $detallesCampos = []; @endphp
                        @foreach ($pregunta->campos_adicionales as $campo)
                            @if (isset($respuesta->detalles['campos'][$campo['name']]))
                                @php 
                                    $valorCampo = $respuesta->detalles['campos'][$campo['name']];
                                    // Formatea fechas si es necesario (ej. para tipo 'month' o 'date')
                                    if(in_array($campo['type'], ['date', 'month', 'date_unknown', 'month_unknown']) && $valorCampo !== 'desconocido') {
                                        try {
                                             $formato = ($campo['type'] === 'month' || $campo['type'] === 'month_unknown') ? 'm/Y' : 'd/m/Y';
                                             $valorCampo = \Carbon\Carbon::parse($valorCampo)->format($formato);
                                        } catch (\Exception $e) { /* Mantener valor original si falla el parseo */ }
                                    }
                                    $detallesCampos[] = $campo['label'] . ': ' . $valorCampo; 
                                @endphp
                            @endif
                        @endforeach
                        {{ implode('; ', $detallesCampos) }}

                    @elseif ($pregunta->tipo_pregunta === 'repetible' && !empty($respuesta->detalles['items']))
                        <ul style="margin: 0; padding-left: 20px; list-style-type: circle;">
                            @foreach ($respuesta->detalles['items'] as $item)
                                <li>
                                    @php $detallesItem = []; @endphp
                                    @foreach ($pregunta->campos_adicionales as $campo)
                                        @if (isset($item[$campo['name']]))
                                             @php 
                                                $valorItem = $item[$campo['name']];
                                                if(in_array($campo['type'], ['date', 'month', 'date_unknown', 'month_unknown']) && $valorItem !== 'desconocido') {
                                                    try {
                                                         $formato = ($campo['type'] === 'month' || $campo['type'] === 'month_unknown') ? 'm/Y' : 'd/m/Y';
                                                         $valorItem = \Carbon\Carbon::parse($valorItem)->format($formato);
                                                    } catch (\Exception $e) { /* Mantener valor original */ }
                                                }
                                                $detallesItem[] = $campo['label'] . ': ' . $valorItem; 
                                            @endphp
                                        @endif
                                    @endforeach
                                    {{ implode('; ', $detallesItem) }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @else
                {{-- Si no fue afirmativa o no hubo respuesta, acumula el nombre de la pregunta --}}
                @php $preguntasSinNovedad[] = $pregunta->pregunta; @endphp
            @endif
        @endforeach

        {{-- Al final de la categoría, si hubo preguntas sin novedad, imprímelas --}}
        @if (!empty($preguntasSinNovedad))
            <p style="margin-bottom: 5px;">
                {{ implode(', ', $preguntasSinNovedad) }} sin nada que reportar.
            </p>
        @endif
        
    @endforeach
    </main>
    
</body>
</html>