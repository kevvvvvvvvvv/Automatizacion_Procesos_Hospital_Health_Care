<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia clínica</title>
    <style>
        @page {
            size: A4;
            margin-top: 5cm; 
            margin-bottom: 1.5cm;
            margin-left: 1cm;
            margin-right: 1cm;

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
            font-size: 10pt; 
            color: #333;
        }

        .header {
            display: flex; 
            justify-content: space-between;
            align-items: center; 
            padding-bottom: 8px;
            margin-bottom: 15px; 
        }

        .header .info-container {
            flex-basis: 45%; 
        }

        .header .logo {
            width: 150px; 
            display: block; 
            margin-bottom: 5px;
        }

        .header .hospital-info { 
             text-align: left; 
             font-size: 8pt; 
             line-height: 1.2;
        }
        .header .hospital-info p {
             margin: 0;
        }

        .identification-card {
            
            padding: 8px 12px; 
            font-size: 9pt; 
            width: 55%;
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

        .footer {
            position: fixed;
            bottom: -0.7cm;  
            left: 0;
            right: 0;
            height: 1cm;
            text-align: right;
            font-size: 9pt;
            color: #888;
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
        <h1>HISTORIA CLÍNICA</h1>
        <span class="id-label">Estado civil:</span>
        <span>{{$paciente['estado_civil']}}</span>
        <span class="id-label">Ocupación:</span>
        <span>{{$paciente['ocupacion']}}</span>
        <span class="id-label">Lugar de origen:</span>
        <span>{{$paciente['lugar_origen']}}</span>
    @foreach ($preguntasPorCategoria as $categoria => $preguntasDeCategoria)
        @if ($categoria !== 'gineco_obstetrico' || ($categoria === 'gineco_obstetrico' && isset($paciente) && $paciente['sexo'] === 'Femenino'))
        <h3 style="margin-top: 15px; margin-bottom: 8px; border-bottom: 1px solid #ccc; padding-bottom: 3px; font-size: 11pt;">
            @if ($categoria == "heredo_familiares")
                Heredo familiares
            @elseif ($categoria == "a_patologicos")
                Antecedentes personales patologicos
            @elseif ($categoria == "no_patologicos")
                Antecedentes personales no patológicos
            @elseif ($categoria == "gineco_obstetrico")
                Antecedentes ginéco-obstétricos
            @elseif ($categoria == "exploracion_fisica")
                Exploración física
            @endif
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
        <div class="signature-section">
            <div class="signature-line"></div>
            <p style="font-size: 9pt; color: #555;">Nombre completo, cédula profesional y firma del médico</p>
            <p>{{ $medico->nombre . " " . $medico->apellido_materno . " " . $medico->apellido_materno}}</p>
            @if(isset($medico) && $medico->credenciales->isNotEmpty())
                <div class="credentials-list">
                    @foreach($medico->credenciales as $credencial)
                        <p>
                            <strong>Título:</strong> {{ $credencial->titulo }} | <strong>Cédula Profesional:</strong> {{ $credencial->cedula_profesional }}
                        </p>
                    @endforeach
                </div>
            @endif
        </div>
       
    </main>
    
</body>
</html>