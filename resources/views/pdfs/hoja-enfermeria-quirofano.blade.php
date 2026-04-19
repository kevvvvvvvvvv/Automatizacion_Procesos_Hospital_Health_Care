<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoja de Enfermería en Quirófano</title>
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

        h3 {
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            page-break-after: avoid;
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
            margin-bottom: 15px;
            color: #000;
        }

        /* Tabla para datos generales (sin bordes visibles) */
        .info-table {
            width: 100%;
            margin-bottom: 10px;
        }
        .info-table td {
            padding: 3px;
            vertical-align: top;
        }

        /* Tabla tipo lista (con bordes) para Insumos, Personal, etc. */
        .list-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 9pt;
        }
        .list-table th, .list-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        .list-table th {
            background-color: #e9e9e9;
            font-weight: bold;
            text-align: center;
        }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }

        /* Checkboxes visuales */
        .check-box {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid #333;
            margin-right: 4px;
            line-height: 8px;
            text-align: center;
            font-size: 8px;
        }
        .checked { background-color: #ccc; }
        .checked::after { content: "X"; font-weight: bold; }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

                .section-content {
            padding-left: 5px;
        }

        .signature-section {
            text-align: center;
            margin-top: 60px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 250px;
            margin: 0 auto;
            margin-bottom: 5px;
        }
        .signature-section p {
            margin: 0;
            line-height: 1.4;
        }

        .empty-cell {
            text-align: center;
            font-style: italic;
            color: #777;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse; 
            margin-bottom: 20px;
        }

        thead th {
            background-color: #f0f0f0;
            color: #222;
            border-bottom: 2px solid #444;
            text-align: left;
            padding: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }


        tbody td {
            padding: 8px 6px; 
            border-bottom: 1px solid #ddd; 
            vertical-align: top; 
            color: #444;
        }

        tbody tr:nth-child(even) {
            background-color: #fcfcfc;
        }


        tr {
            page-break-inside: avoid;
        }

        table td, 
        table th {
            padding: 2px 4px; 
            margin: 0;
            line-height: 1;
        }
    </style>
</head>

<body>
    <h1>Hoja de enfermería en quirófano</h1>

    <h3>Tiempos quirúrgicos</h3>
    <table class="info-table">
        <tr>
            <td><strong>Inicio anestesia:</strong> {{ $notaData['hora_inicio_anestesia'] ?? '--:--' }}</td>
            <td><strong>Inicio cirugía:</strong> {{ $notaData['hora_inicio_cirugia'] ?? '--:--' }}</td>
            <td><strong>Ingreso paciente:</strong> {{ $notaData['hora_inicio_paciente'] ?? '--:--' }}</td>
        </tr>
        <tr>
            <td><strong>Fin anestesia:</strong> {{ $notaData['hora_fin_anestesia'] ?? '--:--' }}</td>
            <td><strong>Fin cirugía:</strong> {{ $notaData['hora_fin_cirugia'] ?? '--:--' }}</td>
            <td><strong>Salida paciente:</strong> {{ $notaData['hora_fin_paciente'] ?? '--:--' }}</td>
        </tr>
    </table>

    <div class="clearfix">
        <div style="width: 100%; overflow: hidden;">
            <h3>Tipo de Anestesia</h3>

            @php
                $anestesia = $notaData['anestesia'] ?? [];
            @endphp

            <div style="width: 100%; margin-bottom: 10px;">
                <div style="float: left; width: 33%;">
                    <span class="check-box {{ ($anestesia['general'] ?? false) ? 'checked' : '' }}"></span>
                    General
                </div>
                <div style="float: left; width: 33%;">
                    <span class="check-box {{ ($anestesia['local'] ?? false) ? 'checked' : '' }}"></span>
                    Local
                </div>
                <div style="float: left; width: 33%;">
                    <span class="check-box {{ ($anestesia['sedacion'] ?? false) ? 'checked' : '' }}"></span>
                    Sedación (MAC)
                </div>
            </div>

            <div style="clear: both; margin-top: 15px; border: 1px solid #eee; padding: 10px;">
                <h4 style="margin-top: 0;">Anestesia Regional (Bloqueos)</h4>
                
                <div style="width: 48%; float: left;">
                    <p style="font-size: 10px; font-weight: bold; color: #666; text-transform: uppercase;">Neuroaxial (Central)</p>
                    <div style="margin-bottom: 5px;">
                        <span class="check-box {{ ($anestesia['regional']['neuroaxial']['bsa'] ?? false) ? 'checked' : '' }}"></span>
                        BSA (Subaracnoideo)
                    </div>
                    <div style="margin-bottom: 5px;">
                        <span class="check-box {{ ($anestesia['regional']['neuroaxial']['epidural'] ?? false) ? 'checked' : '' }}"></span>
                        Epidural
                    </div>
                    <div style="margin-bottom: 5px;">
                        <span class="check-box {{ ($anestesia['regional']['neuroaxial']['mixto'] ?? false) ? 'checked' : '' }}"></span>
                        Bloqueo Mixto (CSE)
                    </div>
                </div>

                <div style="width: 48%; float: right;">
                    <p style="font-size: 10px; font-weight: bold; color: #666; text-transform: uppercase;">Periférico</p>
                    <div style="margin-bottom: 5px;">
                        <span class="check-box {{ ($anestesia['regional']['periferico']['plexo_braquial'] ?? false) ? 'checked' : '' }}"></span>
                        Plexo Braquial
                    </div>
                    <div style="margin-bottom: 5px;">
                        <span class="check-box {{ ($anestesia['regional']['periferico']['otros'] ?? false) ? 'checked' : '' }}"></span>
                        Otros (Femoral, ciático, etc.)
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        <div style="width: 48%; float: left;">
            <h3>Servicios especiales</h3>
            <div>
                @foreach(($notaData['servicios_especiales'] ?? []) as $key => $valor)
                    <div style="margin-bottom: 3px;">
                        <span class="check-box {{ $valor ? 'checked' : '' }}"></span>
                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                    </div>
                @endforeach
                @if(empty($notaData['servicios_especiales']))
                    <p><em>No hay servicios registrados.</em></p>
                @endif
            </div>
        </div>
    </div>

    <h3>Personal en quirófano</h3>
    <table>
        <thead>
            <tr>
                <th>Cargo / Función</th>
                <th>Nombre del Personal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notaData['personalEmpleados'] as $personal)
                <tr>
                    <td>{{ ucfirst($personal['cargo']) }}</td>
                    <td>
                        {{ $personal['user']['name'] ?? 'ID: ' . $personal['user_id'] }} 
                        {{ $personal['user']['apellido_paterno'] ?? '' }}
                        {{ $personal['user']['apellido_materno'] ?? '' }}
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="empty-cell">No se registró personal</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Control de oxígeno</h3>
    <table>
        <thead>
            <tr>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Litros/Min</th>
                <th>Total Consumido</th>
                <th>Responsable</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notaData['hojaOxigenos'] as $oxigeno)
                <tr>
                    <td class="text-center">{{ date('H:i', strtotime($oxigeno['hora_inicio'])) }}</td>
                    <td class="text-center">{{ date('H:i', strtotime($oxigeno['hora_fin'])) }}</td>
                    <td class="text-center">{{ $oxigeno['litros_minuto'] }} L/min</td>
                    <td class="text-center">{{ $oxigeno['total_consumido'] }}</td>
                    <td>{{ $oxigeno['user_inicio']['name'] ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty-cell">No se registró consumo de oxígeno</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Medicamentos utilizados</h3>
    <table>
        <thead>
            <tr>
                <th style='width:30%'>Fecha/Hora registro</th>
                <th style='width:10%'>ID Medicamento</th>
                <th style='width:50%'>Nombre del medicamento</th>
                <th style='width:10%'>Cantidad (unidades)</th>
               
            </tr>
        </thead>
        <tbody>
            @if ($notaData['hojaInsumosBasicos']->isEmpty())
                <tr>
                    <td colspan="3" class='empty-cell'>No se han registrado medicamentos.</td>
                </tr>
            @else
                @foreach ($notaData['hojaInsumosBasicos'] as $insumos)
                        <tr>
                            <td>{{$insumos->created_at}}</td>
                            <td>{{$insumos->producto_servicio_id}}</td>
                            <td>{{$insumos['productoServicio']->nombre_prestacion}}</td>
                            <td>{{$insumos->cantidad}}</td>
                            
                        </tr>                        
                @endforeach

            @endif
        </tbody>
    </table>

    <h3>Conteo de material en quirofano</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha/hora</th>
                <th>Tipo de material</th>
                <th>Cantidad inicial</th>
                <th>Cantidad agregada</th>
                <th>Cantidad final</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData['conteoMaterialQuirofano']->isEmpty())
                <tr>
                    <td colspan="3" class='empty-cell'>No se han registrado insumos utilizados.</td>
                </tr>
            @else
                @foreach ($notaData['conteoMaterialQuirofano'] as $material)
                    <tr>
                        <td>{{$material->created_at}}</td>
                        <td>{{$material->tipo_material_leible}}</td>
                        <td>{{$material->cantidad_inicial}}</td>
                        <td>{{$material->cantidad_agregada}}</td>
                        <td>{{$material->cantidad_final}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h3>Isquemias</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha/hora</th>
                <th>Sitio anatómico</th>
                <th>Hora de inicio</th>
                <th>Hora de termino</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData['isquemias']->isEmpty())
                <tr>
                    <td colspan="3" class='empty-cell'>No se han registrado insumos utilizados.</td>
                </tr>
            @else
                @foreach ($notaData['isquemias'] as $isquemia)
                    <tr>
                        <td>{{$isquemia->created_at}}</td>
                        <td>{{$isquemia->sitio_anatomico}}</td>
                        <td>{{$isquemia->hora_inicio}}</td>
                        <td>{{$isquemia->hora_termino}}</td>
                        <td>{{$isquemia->observaciones}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h3>Signos vitales</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha/Hora</th>
                <th title="Tensión Arterial">Tensión arterial</th>
                <th title="Frecuencia Cardíaca">Frecuencia cardiaca</th>
                <th title="Frecuencia Respiratoria">Frecuencia respiratoria</th>
                <th title="Temperatura">Temperatura</th>
                <th title="Saturación de Oxígeno">Saturación de oxígeno</th>
                <th title="Glucemia Capilar">Glucemia capilar</th>
                <th>Peso</th>
                <th>Talla</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData['hojaSignos']->isEmpty())
                <tr>
                    <td colspan="9" class='empty-cell'>No se han registrado signos vitales.</td>
                </tr>
            @else
                @foreach ($notaData['hojaSignos'] as $signo)
                    <tr>
                        <td>{{ $signo->fecha_hora_registro }}</td>
                        
                        <td>
                            {{ $signo->tension_arterial_sistolica && $signo->tension_arterial_diastolica 
                                ? $signo->tension_arterial_sistolica . '/' . $signo->tension_arterial_diastolica 
                                : '' }}
                        </td>

                        <td>{{ $signo->frecuencia_cardiaca }}</td>
                        <td>{{ $signo->frecuencia_respiratoria }}</td>
                        
                        <td>{{ $signo->temperatura ? $signo->temperatura . ' °C' : '' }}</td>
                        <td>{{ $signo->saturacion_oxigeno ? $signo->saturacion_oxigeno . ' %' : '' }}</td>
                        <td>{{ $signo->glucemia_capilar ? $signo->glucemia_capilar . ' mg/dl' : '' }}</td>
                        <td>{{ $signo->peso ? $signo->peso . ' kg' : '' }}</td>
                        <td>{{ $signo->talla ? $signo->talla . ' cm' : '' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h3>Ministración de medicamentos</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Medicamento</th>
                <th style="width: 10%;">Dosis</th>
                <th style="width: 10%;">Gramaje</th>
                <th style="width: 15%;">Vía administración</th>
                <th style="width: 10%;">Duración</th>
                <th style="width: 10%;">Unidad</th>
                <th style="width: 20%;">Fecha/Hora Aplicación</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->hojaMedicamentos->isEmpty())
                <tr>
                    <td colspan="7" class="empty-cell">
                        No se han registrado medicamentos administrados.
                    </td>
                </tr>
            @else
                @foreach ($notaData->hojaMedicamentos as $medicamento)
                    <tr>
                        <td><strong>{{ $medicamento->nombre_medicamento }}</strong></td>
                        <td>{{ $medicamento->dosis }}</td>
                        <td>{{ $medicamento->gramaje }}</td>
                        <td>{{ $medicamento->via_administracion }}</td>
                        <td>{{ $medicamento->duracion_tratamiento }}</td>
                        <td>{{ $medicamento->unidad }}</td>
                        <td>
                            <span class="fecha-item">{{ $medicamento->fecha_hora_inicio }}</span>
                            @if (!$medicamento->aplicaciones->isEmpty())
                                @foreach ($medicamento->aplicaciones as $aplicacion)
                                    <span class="fecha-item" style="color: #666;">
                                        {{ $aplicacion->fecha_aplicacion }}
                                    </span>
                                @endforeach
                            @endif
                        </td> 
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <h3>Terapia intravenosa</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 70%">Solución</th>
                <th style="width: 10%">Cantidad (ml)</th>
                <th style="width: 10%">Duración</th>
                <th style="width: 10%">Flujo (ml/hora)</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->hojasTerapiaIV->isEmpty())
                <tr>
                    <td colspan="4" class="empty-cell">
                        No se han registrado terapias intravenosas.
                    </td>
                </tr>
            @else
                @foreach ($notaData->hojasTerapiaIV as $terapia)
                    <tr>
                        <td>
                            {{$terapia->nombre_solucion}}
                            @if ($terapia->medicamentos && $terapia->medicamentos->isNotEmpty())
                                @foreach ($terapia->medicamentos as $medicamento)
                                    <div class='text-gray-400'>
                                        {{ $medicamento->nombre_medicamento }} | {{$medicamento->dosis }} {{ $medicamento->unidad_medida }}
                                    </div>
                                @endforeach
                            @endif
                        </td>
                        <td>{{$terapia->cantidad}}</td>
                        <td>{{$terapia->duracion}}</td>
                        <td>{{$terapia->flujo_ml_hora}}</td>
                    </tr>
                @endforeach

            @endif

        </tbody>
    </table>


    <h3>Egresos</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 40%">Fecha/Hora</th>
                <th style="width: 20%">Tipo de egreso</th>
                <th style="width: 20%">Cantidad (ml)</th>
                <th style="width: 30%">Descripción</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->egresoLiquidos->isEmpty())
                <tr>
                    <td colspan="4" class="empty-cell">
                        No se han registrado terapias intravenosas.
                    </td>
                </tr>
            @else
                @foreach ($notaData->egresoLiquidos as $egreso)
                    <tr>
                        <td>{{$egreso->created_at}}</td>
                        <td>{{$egreso->tipo}}</td>
                        <td>{{$egreso->cantidad}}</td>
                        <td>{{$egreso->duracion}}</td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>

    <h3>Administración de oxígeno</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Flujo (L/min)</th>
                <th style="width: 15%;">Inicio</th>
                <th style="width: 15%;">Fin</th>
                <th style="width: 10%;">Total</th>
                <th style="width: 25%;">Personal que inició</th>
                <th style="width: 25%;">Personal que finalizó</th>
            </tr>
        </thead>
        <tbody>
            @if ($notaData->hojaOxigenos->isEmpty())
                <tr>
                    {{-- IMPORTANTE: Cambié el colspan a 6 porque ahora son 6 columnas --}}
                    <td colspan="6" class="empty-cell">No se ha registrado administración de oxígeno.</td>
                </tr>
            @else
                @foreach ($notaData->hojaOxigenos as $oxigeno)
                    <tr>   
                        {{-- 1. Flujo --}}
                        <td style="text-align: center;">{{ $oxigeno->litros_minuto }}</td>

                        {{-- 2. Hora Inicio --}}
                        <td style="font-size: 0.9em;">{{ $oxigeno->hora_inicio }}</td>

                        {{-- 3. Hora Fin --}}
                        @if (!$oxigeno->hora_fin)
                            <td class="empty-data" style="font-style: italic; color: #666; font-size: 0.9em;">
                                En curso
                            </td>
                        @else
                            <td style="font-size: 0.9em;">{{ $oxigeno->hora_fin }}</td>
                        @endif

                        {{-- 4. Total Consumido (Nuevo) --}}
                        <td style="text-align: center; font-weight: bold;">
                            {{ $oxigeno->total_consumido ?? 0 }} L
                        </td>

                        {{-- 5. Personal Inicio (Nuevo) --}}
                        {{-- Accedemos a las propiedades del objeto userInicio --}}
                        <td style="font-size: 0.85em;">
                            {{ $oxigeno->userInicio->nombre ?? '' }} {{ $oxigeno->userInicio->apellido_paterno ?? '' }}
                        </td>

                        {{-- 6. Personal Fin (Nuevo) --}}
                        <td style="font-size: 0.85em;">
                            @if ($oxigeno->userFin)
                                {{ $oxigeno->userFin->nombre }} {{ $oxigeno->userFin->apellido_paterno }}
                            @else
                                <span style="color: #aaa;">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    @if(isset($medico))
        @php
            $firmante = $medico->colaborador_responsable ?? $medico;
        @endphp

        <div class="signature-section">
            <div class="signature-line"></div>
            <p style="font-size: 9pt; color: #555;">Nombre completo, cédula profesional y firma del médico</p>
            
            <p>
                {{ $firmante->nombre_completo }} 
            </p>

            @if($firmante->credenciales->isNotEmpty())
                <div class="credentials-list">
                    @foreach($firmante->credenciales as $credencial)
                        <p>
                            <strong>Título:</strong> {{ $credencial->titulo }} | 
                            <strong>Cédula Profesional:</strong> {{ $credencial->cedula_profesional }}
                        </p>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

</body>
</html>