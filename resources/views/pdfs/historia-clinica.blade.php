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
        <span class="id-label">Estado civil:</span>
        <span>{{$paciente['estado_civil']}}</span>
        <span class="id-label">Ocupación:</span>
        <span>{{$paciente['ocupacion']}}</span>
        <span class="id-label">Lugar de origen:</span>
        <span>{{$paciente['lugar_origen']}}</span>
@foreach ($preguntasPorCategoria as $categoria => $preguntasDeCategoria)
        
        <h3 style="margin-top: 15px; margin-bottom: 8px; border-bottom: 1px solid #ccc; padding-bottom: 3px; font-size: 11pt;">
            {{ ucwords(str_replace('_', ' ', $categoria)) }} 
        </h3>
        @if ($categoria === 'exploracion_fisica')
            <div style="margin-bottom: 8px;">
                <strong style="text-decoration: underline;">Padecimiento actual:</strong>
                <span>{{ $historiaclinica['padecimiento_actual'] }}</span>
            </div>
            <p style="line-height: 1.4; margin: 0; margin-bottom: 10px;">
                <strong>Tensión arterial:</strong> {{$historiaclinica['tension_arterial']}} mm Hg | 
                <strong>Frecuencia cardiaca:</strong> {{$historiaclinica['frecuencia_cardiaca']}} x min | 
                <strong>Frecuencia respiratoria:</strong> {{$historiaclinica['frecuencia_respiratoria']}} x min | 
                <strong>Temperatura:</strong> {{$historiaclinica['temperatura']}} °C | 
                <strong>Peso:</strong> {{$historiaclinica['peso']}} kg | 
                <strong>Talla:</strong> {{$historiaclinica['talla']}} cm
            </p>
        @endif

        @php
            
            $preguntasConDetalles = []; 
            $preguntasSinNovedad = [];  
        @endphp


        @foreach ($preguntasDeCategoria as $pregunta)
            @php
                $respuesta = $respuestasMap->get($pregunta->id);
                $valorRespuesta = $respuesta ? ($respuesta->detalles['respuesta'] ?? null) : null;
                
                $esAfirmativa = false;
                if ($valorRespuesta) {
                    $opcionesRespuesta = $pregunta->opciones_respuesta ?? null;
                    if ($opcionesRespuesta && is_array($opcionesRespuesta)) {
                        $opcionSeleccionada = collect($opcionesRespuesta)->firstWhere('value', $valorRespuesta);
                        if ($opcionSeleccionada && ($opcionSeleccionada['triggersFields'] ?? false)) {
                            $esAfirmativa = true;
                        }
                    } elseif ($valorRespuesta === 'si') {
                        $esAfirmativa = true;
                    }
                }
            @endphp

            @if ($esAfirmativa)
                @php
                    $detalleString = '';
                    $campos = $respuesta->detalles['campos'] ?? [];
                    $items = $respuesta->detalles['items'] ?? [];

                    if ($pregunta->tipo_pregunta === 'simple' && isset($campos['detalle'])) {
                        $detalleString = $campos['detalle'];
                    } elseif (!empty($campos) && is_array($pregunta->campos_adicionales)) {
                        $partes = [];
                        foreach ($pregunta->campos_adicionales as $campoDefinicion) {
                            if (isset($campos[$campoDefinicion['name']])) {
                                $valor = $campos[$campoDefinicion['name']];
                                
                                if (in_array($campoDefinicion['type'], ['date', 'month', 'date_unknown', 'month_unknown']) && $valor !== 'desconocido') {
                                    try {
                                        $formato = (strpos($campoDefinicion['type'], 'month') !== false) ? 'm/Y' : 'd/m/Y';
                                        $valor = \Carbon\Carbon::parse($valor)->format($formato);
                                    } catch (\Exception $e) { }
                                }
                                $partes[] = $campoDefinicion['label'] . ': ' . $valor;
                            }
                        }
                        $detalleString = implode('; ', $partes);
                    } elseif (!empty($items) && is_array($pregunta->campos_adicionales)) {
                         $partesItems = [];
                         foreach($items as $item) {
                             $subPartes = [];
                             foreach($pregunta->campos_adicionales as $campoDefinicion) {
                                 if(isset($item[$campoDefinicion['name']])) {
                                      $subPartes[] = $campoDefinicion['label'] . ': ' . $item[$campoDefinicion['name']];
                                 }
                             }
                             $partesItems[] = implode('; ', $subPartes);
                         }
                         $detalleString = implode(' | ', $partesItems);
                    }
                    
                    
                    $preguntasConDetalles[] = '<strong style="text-decoration: underline;">' . $pregunta->pregunta . ':</strong> ' . $detalleString;
                @endphp
            @else
                
                @php $preguntasSinNovedad[] = $pregunta->pregunta; @endphp
            @endif
        @endforeach

        
        @if (!empty($preguntasConDetalles))
            <p style="margin: 0 0 5px 0; line-height: 1.4;">
                {!! implode(', ', $preguntasConDetalles) !!}
            </p>
        @endif

        
        @if (!empty($preguntasSinNovedad))
            <p style="margin: 0 0 5px 0; line-height: 1.4; color: #555;">
                {{ implode(', ', $preguntasSinNovedad) }} sin nada que reportar.
            </p>
        @endif
    @endforeach
        <section>
            <div>
                <span class="id-label">Resultados previos y actuales de laboratorio y gabinete:</span>
                <span>{{$historiaclinica['resultados_previos']}}</span>
            </div>

            <div>
                <span class="id-label">Diagnósticos o problemas clínicos:</span>
                <span>{{$historiaclinica['diagnostico']}}</span>
            </div>

            <div>
                <span class="id-label">Pronóstico:</span>
                <span>{{$historiaclinica['pronostico']}}</span>
            </div>

            <div>
               <span class="id-label">Indicación terapéutica:</span>
                <span>{{$historiaclinica['indicacion_terapeutica']}}</span>             
            </div>
        </section>
    </main>
    
</body>
</html>