<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Estudios Quirúrgicos</title>
    <style>
        @page {
            size: A4;
            margin: 1.2cm;
        }
        body {
            font-family: Calibri, Arial, sans-serif;
            font-size: 9.5pt;
            line-height: 1.2;
            color: #333;
        }
        
        /* HEADER */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #333;
            margin-bottom: 15px;
        }
        .logo {
            width: 160px;
            height: auto;
            display: block;
        }
        .titulo-container {
            text-align: center;
            vertical-align: middle;
        }
        .titulo {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        /* TABLA DE DATOS */
        .tabla-datos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        .tabla-datos td {
            padding: 3px 2px;
            vertical-align: bottom;
        }
        .label {
            font-weight: bold;
            font-size: 8.5pt;
        }
        .linea-llenado {
            border-bottom: 1px solid #333;
            display: inline-block;
            width: 100%;
            min-height: 14px;
        }

        /* SECCIONES */
        .seccion-titulo {
            background-color: #55bce9;
            padding: 4px 10px;
            font-weight: bold;
            margin-top: 10px;
            border: 1px solid #333;
            text-transform: uppercase;
            font-size: 9.5pt;
        }
        .subarea-titulo {
            font-weight: bold;
            text-decoration: underline;
            margin: 6px 0 3px 5px;
            font-size: 8.5pt;
        }
        .grid-container {
            width: 100%;
        }
        .grid-item {
            width: 32%;
            display: inline-block;
            vertical-align: top;
            margin-bottom: 3px;
            font-size: 8pt;
        }
        .check-box {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid #333;
            margin-right: 4px;
            vertical-align: middle;
        }
        
        /* ESTILO PARA "OTROS" */
        .otros-linea {
            width: 100%;
            margin-top: 4px;
            font-size: 8pt;
            font-weight: bold;
        }
        .otros-puntos {
            border-bottom: 1px solid #333;
            display: inline-block;
            width: 80%; /* Ajusta el largo de la línea */
            margin-left: 5px;
        }

        .clearfix { clear: both; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 25%;">
                <img src="{{ public_path('images/Logo_HC_2.png') }}" class="logo">
            </td>
            <td class="titulo-container">
                <div class="titulo">Solicitud de Paquete de<br>Estudios Quirúrgicos</div>
            </td>
            <td style="width: 20%; text-align: right; font-size: 8pt;">
                <strong>FECHA:</strong> {{ date('d/m/Y') }}
            </td>
        </tr>
    </table>

    <table class="tabla-datos">
        <tr>
            <td style="width: 10%;"><span class="label">Paciente:</span></td>
            <td style="width: 50%;"><span class="linea-llenado"></span></td>
            <td style="width: 8%; text-align: right;"><span class="label">Edad:</span></td>
            <td style="width: 12%;"><span class="linea-llenado"></span></td>
            
            <td style="width: 15%; text-align: right;"><span class="label">F. Nacimiento:</span></td>
            <td style="width: 20%;"><span class="linea-llenado"></span></td>
        </tr>
    </table>

    <table class="tabla-datos">
        <tr>
            <td style="width: 12%;"><span class="label">Valoración:</span></td>
            <td style="width: 53%;"><span class="linea-llenado"></span></td>
            
            <td style="width: 10%; text-align: right;"><span class="label">Instrumentista:</span></td>
            <td style="width: 20%;"><span class="linea-llenado"></span></td>
        </tr>
    </table>

    <table class="tabla-datos">
        <tr>
            <td style="width: 10%;"><span class="label">Familiar:</span></td>
            <td style="width: 30%;"><span class="linea-llenado"></span></td>
            <td style="width: 10%; text-align: right;"><span class="label">Cirujano:</span></td>
            <td style="width: 20%;"><span class="linea-llenado"></span></td>
            <td style="width: 10%; text-align: right;"><span class="label">Ayudante:</span></td>
            <td style="width: 20%;"><span class="linea-llenado"></span></td>
        </tr>
    </table>
     <table class="tabla-datos">
        <tr>
            <td style="width: 10%;"><span class="label">Tel. Paciente:</span></td>
            <td style="width: 30%;"><span class="linea-llenado"></span></td>
            <td style="width: 10%; text-align: right;"><span class="label">Tel. Familiar:</span></td>
            <td style="width: 20%;"><span class="linea-llenado"></span></td>
            <td style="width: 10%; text-align: right;"><span class="label">Anestesiólogo:</span></td>
            <td style="width: 20%;"><span class="linea-llenado"></span></td>

        </tr> 
    </table>
    

    

    @php
        $secciones = [
            ['titulo' => 'Paquetes Cirugía', 'items' => ['Colecistectomía por laparo', 'HTA', 'Cesárea', 'Vasectomía', 'RTUP', 'Hernioplastia umbilical', 'Hernia inguinal', 'Quiste de ovario', 'Hernioplastia bilateral', 'Fractura']],
            ['titulo' => 'Estudios de Laboratorio', 'subareas' => [
                ['nombre' => 'Estudios de orina', 'items' => ['Examen general de orina', 'Proteínas totales en orina', 'Depuración de creatinina', 'Calcio en orina']],
                ['nombre' => 'Química clínica', 'items' => ['Hemoglobina glicosilada', 'Química sanguínea (6 elem.)', 'Electrolitos', 'Perfil hepático', 'Acido urico en suero', 'Creatina en suero', 'Química sanguinea de 36 elementos', 'Reacciones febriles']],
                ['nombre' => 'Pruebas de hemostasia', 'items' => ['Tiempo de protrombina', 'Tiempo de tromboplastina parcial activado (APTT)', 'Coagulograma básico (TP, TTP, TS, TC, BH)', 'Tiempo de sangrado (Adhesividad plaquetaria)', 'Tiempo de coagulación']],
                ['nombre' => 'Hematología ', 'items' => ['Biometría hemática', 'Grupo y factor RH', 'Velocidad de sedminetación globular']]
            ]],
            ['titulo' => 'Estudios de Imagen', 'items' => ['Abdomen completo', 'Hígado y vías biliares', 'Renal y vías excretoras', 'Pélvico ginecológico', 'Tele de tórax', 'Columna lumbar OA y lateral']],
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
                        <div class="grid-item">
                            <span class="check-box"></span>
                            {{ $item }}
                        </div>
                    @endforeach
                    <div class="otros-linea">
                        <span>Otros:</span><span class="otros-puntos"></span>
                    </div>
                    <div class="clearfix"></div>
                </div>
            @endforeach
        @else
            <div class="grid-container" style="margin-top: 5px;">
                @foreach($seccion['items'] as $item)
                    <div class="grid-item">
                        <span class="check-box"></span>
                        {{ $item }}
                    </div>
                @endforeach
                <div class="otros-linea">
                    <span>Otros:</span><span class="otros-puntos"></span>
                </div>
                <div class="clearfix"></div>
            </div>
        @endif
    @endforeach

</body>
</html>