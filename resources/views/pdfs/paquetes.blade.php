<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: A4; margin: 1cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 9pt; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2c3e50; padding-bottom: 10px; }
        .titulo { font-size: 14pt; font-weight: bold; text-transform: uppercase; }
        
        .info-paciente { width: 100%; margin-bottom: 15px; border: 1px solid #ccc; padding: 10px; border-radius: 5px; }
        
        .seccion-titulo { 
            background-color: #f2f2f2; 
            padding: 5px 10px; 
            font-weight: bold; 
            border-left: 4px solid #2c3e50;
            margin-top: 15px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .grid-container { width: 100%; margin-bottom: 10px; }
        .grid-item { width: 33.3%; float: left; margin-bottom: 4px; }
        
        /* Simulación de Checkbox */
        .check-box { 
            display: inline-block; 
            width: 12px; 
            height: 12px; 
            border: 1px solid #000; 
            margin-right: 5px; 
            text-align: center;
            line-height: 10px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
        .checked { background-color: #e2e2e2; }
        
        .clearfix { clear: both; }
        .subarea-titulo { font-weight: bold; font-size: 8pt; color: #555; margin: 5px 0; border-bottom: 1px solid #eee; }
        
        .footer-firmas { margin-top: 40px; width: 100%; }
        .firma-box { width: 45%; float: left; text-align: center; }
        .linea { border-top: 1px solid #000; margin-top: 40px; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="titulo">Solicitud de Paquete de Estudios Quirúrgicos</div>
        <div>Hospitalidad Health Care</div>
    </div>

    <div class="info-paciente">
        <table width="100%">
            <tr>
                <td><strong>Paciente:</strong> {{ $paciente->nombre_completo }}</td>
                <td><strong>Fecha:</strong> {{ $fecha['dia'] }}/{{ $fecha['mes'] }}/{{ $fecha['anio'] }}</td>
            </tr>
            <tr>
                <td><strong>Habitación:</strong> {{ $estancia->habitacion ?? 'N/A' }}</td>
                <td><strong>Folio:</strong> #{{ $solicitud->id }}</td>
            </tr>
        </table>
    </div>

    @php
        // Definimos la misma estructura que tienes en React
        $secciones = [
            ['titulo' => 'Paquetes Cirugía', 'items' => ['Colecistectomía por laparo', 'HTA', 'Cesarea', 'Vasectomía', 'RTUP', 'Herminiplastia umbilical', 'Hernia inguinal', 'Quiste de ovario', 'Hernioplastia bilateral', 'Fractura']],
            ['titulo' => 'Estudios de Laboratorio', 'subareas' => [
                ['nombre' => 'Estudios de orina', 'items' => ['Examen general de orina', 'Proteína totales en orina', 'Depuración de cretinina en orina', 'Calcio en orina']],
                ['nombre' => 'Pruebas de hemostasia', 'items' => ['Tiempo de protrombina', 'Tiempo de tromboplastina parcial activa(APTT)', 'Coagulograma básico(TP, TTP, TS, TC, BH)', 'Tiempo de sangrado', 'Tiempo de coagulación']],
                ['nombre' => 'Hematología y Química', 'items' => ['Biometria hemática', 'Grupo y factor RH', 'Hemoglobina glicosada', 'Quìmica sanguinea de 6 elementos', 'Electrolitos', 'Perfil heaptico']]
            ]],
            ['titulo' => 'Estudios de Imagen', 'items' => ['Abdomen completo', 'Hígado y vias biliares', 'Renal y vias excretoras', 'Pelvico ginecologico', 'Tele de torax', 'Columna lumbar OA y lateral']],
            ['titulo' => 'Consulta Especialidad', 'items' => ['Ginecología', 'Urología', 'Oncología', 'Cirugía general', 'Internista']]
        ];
    @endphp

    @foreach($secciones as $seccion)
        <div class="seccion-titulo">{{ $seccion['titulo'] }}</div>
        
        @if(isset($seccion['subareas']))
            @foreach($seccion['subareas'] as $sub)
                <div class="subarea-titulo">{{ $sub['nombre'] }}</div>
                <div class="grid-container">
                    @foreach($sub['items'] as $item)
                        @php $isMarked = in_array(trim(mb_strtolower($item, 'UTF-8')), $seleccionados); @endphp
                        <div class="grid-item">
                            <span class="check-box {{ $isMarked ? 'checked' : '' }}">{{ $isMarked ? 'X' : '' }}</span>
                            {{ $item }}
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            @endforeach
        @else
            <div class="grid-container">
                @foreach($seccion['items'] as $item)
                    @php $isMarked = in_array(trim(mb_strtolower($item, 'UTF-8')), $seleccionados); @endphp
                    <div class="grid-item">
                        <span class="check-box {{ $isMarked ? 'checked' : '' }}">{{ $isMarked ? 'X' : '' }}</span>
                        {{ $item }}
                    </div>
                @endforeach
                <div class="clearfix"></div>
            </div>
        @endif
    @endforeach

    {{-- Otros estudios manuales que no están en la lista fija --}}
    @php
        // Filtrar los que NO están en la lista de items fijos arriba
        $todosLosItemsFijos = [];
        foreach($secciones as $s) {
            if(isset($s['items'])) $todosLosItemsFijos = array_merge($todosLosItemsFijos, array_map(fn($i) => trim(mb_strtolower($i, 'UTF-8')), $s['items']));
            if(isset($s['subareas'])) {
                foreach($s['subareas'] as $sub) $todosLosItemsFijos = array_merge($todosLosItemsFijos, array_map(fn($i) => trim(mb_strtolower($i, 'UTF-8')), $sub['items']));
            }
        }
        $manualesUnicos = array_diff($seleccionados, $todosLosItemsFijos);
    @endphp

    @if(count($manualesUnicos) > 0)
        <div class="seccion-titulo">Otros Estudios Solicitados</div>
        <div class="grid-container">
            @foreach($manualesUnicos as $manual)
                <div class="grid-item">
                    <span class="check-box checked">X</span>
                    <span style="text-transform: capitalize;">{{ $manual }}</span>
                </div>
            @endforeach
            <div class="clearfix"></div>
        </div>
    @endif

    <div class="footer-firmas">
        <div class="firma-box">
            <div class="linea">Firma Médico Solicitante</div>
            <p>{{ $solicitud->userSolicita->name ?? '________________' }}</p>
        </div>
        <div class="firma-box" style="float: right;">
            <div class="linea">Firma de Recepción / Laboratorio</div>
        </div>
        <div class="clearfix"></div>
    </div>
</body>
</html>