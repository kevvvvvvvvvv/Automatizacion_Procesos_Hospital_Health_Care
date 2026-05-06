<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Estudios Quirúrgicos</title>
    <style>
        @page {
            size: A4;
            margin: 0.4cm;
        }
        body {
            font-family: Calibri, Arial, sans-serif;
            font-size: 8.5pt;
            line-height: 1;
            color: #333;
        }
        
        .header-table {
            width: 100%;
            border-bottom: 1px solid #333;
            margin-bottom: 8px;
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

        .tabla-datos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
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
        .seccion-titulo {
            background-color: #55bce9;
            padding: 2px 5px;
            font-weight: bold;
            margin-top: 5px;
            border: 1px solid #333;
            text-transform: uppercase;
            font-size: 7.5pt;
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
        .incluye-box {
            width: 185%;
            border: 1px solid #333;
            min-height: 70px;
            margin-top: 5px;
            padding: 5px;
            font-size: 8pt;
        }
        .costo-paquete {
            text-align: right;
            margin-top: 10px;
            font-weight: bold;
            font-size: 10pt;
        }
        .linea-costo {
            border-bottom: 1px solid #333;
            display: inline-block;
            width: 120px;
            margin-left: 5px;
        }

        .otros-linea {
            width: 100%;
            margin-top: 4px;
            font-size: 8pt;
            font-weight: bold;
        }
        .otros-puntos {
            border-bottom: 1px solid #333;
            display: inline-block;
            width: 80%;
            margin-left: 5px;
        }
        .text-red { 
            color: #dc2626; 
            font-weight: bold; 
            text-align: center; 
        }
        .text-black { 
            Color: #000; 
            font-weight: bold; 
            text-align: center; 
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
            <td style="width: 40%;"><span class="linea-llenado"></span></td>
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
                ['nombre' => 'Química clínica', 'items' => ['Hemoglobina glicosilada', 'Química sanguínea (6 elem.)', 'Electrolitos', 'Perfil hepático', 'Acido urico en suero', 'Creatina en suero', 'Química sanguinea de 36 elementos', 'Reacciones febriles']],                
                ['nombre' => 'Estudios de orina', 'items' => ['Examen general de orina', 'Proteínas totales en orina', 'Depuración de creatinina', 'Calcio en orina']],
                ['nombre' => 'Pruebas de hemostasia', 'items' => ['Tiempo de protrombina', 'Tiempo de coagulación', 'Coagulograma básico (TP, TTP, TS, TC, BH)', 'Tiempo de sangrado (Adhesividad plaquetaria)', 'Tiempo de tromboplastina parcial activado (APTT)']],
                ['nombre' => 'Hematología ', 'items' => ['Biometría hemática', 'Grupo y factor RH', 'Velocidad de sedminetación globular']]
            ]],
            ['titulo' => 'Estudios de Ultrasonido', 'items' => ['Abdomen completo', 'Hígado y vías biliares', 'Renal y vías excretoras', 'Pélvico ginecológico', 'Trans-vaginal', 'Trans-rectal', 'Partes blandas', 'Articular (rodillas, hombrol, tobillo)', 'Inguinal', 'Doppler color', 'Cariotidas', 'MPI Arterial', 'MPI venoso']],
            ['titulo' => 'Rayos X', 'items' => ['Tele del torax', 'Columna labr OA y lateral', 'Cervical', 'Dorsal', 'Hombro', 'Muñeca', 'Creaneo', 'Senos dorsales']],
            ['titulo' => 'Otros', 'items' => ['Electrocardiograma', 'Tococardriograma', 'Edad osea']],
            ['titulo' => 'Consulta Especialidad', 'items' => ['Ginecología', 'Urología', 'Oncología', 'Cirugía general', 'Internista', 'Interconsulta']],
        ];
    @endphp
    
    @foreach($secciones as $seccion)
        <div class="seccion-titulo">{{ $seccion['titulo'] }}</div>
        @if($seccion['titulo'] == 'Paquetes Cirugía')
            <table style="width: 100%; border-collapse: collapse; margin-top: 1px;">
                <tr><td style="width: 40%; vertical-align: top;">
                        <div class="grid-container">
                            @foreach($seccion['items'] as $item)
                                <div style="font-size: 8pt; margin-bottom: 2px; width: 48%; display: inline-block; vertical-align: top;">
                                    <span class="check-box"></span>
                                    {{ $item }}
                                </div>
                            @endforeach
                            <div class="otros-linea">
                                <span>Otros:</span><span class="otros-puntos" style="width: 70%;"></span>
                            </div>
                        </div>
                    </td>
                    
                    <td style="width: 25%; vertical-align: top; padding: 0 10px;">
                        <table style="width: 100%; border: 1px solid #333; border-collapse: collapse; font-size: 7.5pt;">
                            <tr>
                                <th colspan="2" style="background-color: #f2f2f2; border: 1px solid #333; padding: 2px; font-size: 7pt;">SIGNOS VITALES</th>
                            </tr>
                            <tr><td style="border: 1px solid #333; padding: 2px;">T.A.</td><td style="border: 1px solid #333; width: 60%;"></td></tr>
                            <tr><td style="border: 1px solid #333; padding: 2px;">F.C.</td><td style="border: 1px solid #333;"></td></tr>
                            <tr><td style="border: 1px solid #333; padding: 2px;">F.R.</td><td style="border: 1px solid #333;"></td></tr>
                            <tr><td style="border: 1px solid #333; padding: 2px;">TEMP.</td><td style="border: 1px solid #333;"></td></tr>
                            <tr><td style="border: 1px solid #333; padding: 2px;">SPO2</td><td style="border: 1px solid #333;"></td></tr>
                            <tr><td style="border: 1px solid #333; padding: 2px;">PESO</td><td style="border: 1px solid #333;"></td></tr>
                            <tr><td style="border: 1px solid #333; padding: 2px;">TALLA</td><td style="border: 1px solid #333;"></td></tr>
                        </table>
                    </td>
                    
                </tr>
            </table>
            
        
        @elseif($seccion['titulo'] == 'Estudios de Laboratorio')
            <table style="width: 85%; border-collapse: collapse; margin-top: 5px;">
                <tr>
                    <td style="width: 80%; vertical-align: top;">
                        @foreach($seccion['subareas'] as $sub)
                            <div class="subarea-titulo" style="margin-top: 2px;">{{ $sub['nombre'] }}</div>
                            <div class="grid-container">
                                @foreach($sub['items'] as $item)
                                    @php
                                        $ancho = ($sub['nombre'] == 'Química clínica') ? '100%' : '48%';
                                    @endphp
                                    
                                    <div class="grid-item" style="width: {{ $ancho }}; font-size: 7.5pt; display: inline-block; vertical-align: top; margin-bottom: 2px;">
                                        <span class="check-box"></span>{{ $item }}
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <div class="otros-linea" style="margin-top: 10px;">
                            <span>Otros:</span><span class="otros-puntos" style="width: 80%;"></span>
                        </div>
                    </td>

                    <td style="width: 85%; vertical-align: top; padding-left: 5px; padding-top: 10px;">
                        <div style="position: sticky; top: 0;">
                            <span class="label">INCLUYE:</span>
                            <div class="incluye-box" style="min-height: 225px;">
                                </div>
                            <div class="costo-paquete" style="text-align: left; margin-top: 1px;">
                                Costo del paquete <br>
                                <div style="margin-top: 5px;">
                                    $ <span class="linea-costo" style="width: 100px;"></span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            
        @elseif(isset($seccion['subareas']))
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
    <table class="tabla-datos">
        <tr>
            <td style="width: 20%;"><span class="label">Médico de primer contacto:</span></td>
            <td style="width: 40%;"><span class="linea-llenado"></span></td>
            <td style="width: 8%; text-align: right;"><span class="label">Seguimiento:</span></td>
            <td style="width: 40%;"><span class="linea-llenado"></span></td> 
        </tr>
    </table>
    <table class="tabla-datos">
        <tr>
            <td style="width: 15%;"><span class="label">Tratamiento:</span></td>
            <td style="width: 120%;"><span class="linea-llenado"></span></td>
        </tr>
    </table>
    <p class="text-black">Autoriza                          Paciente</p>
        <p class="text-red">PROMOCION DE PAQUETE SOLO VALIDO PAGANDO EN EFECTIVO NO APLICA EN OTRAS PROMOCIONES.</p>

    

</body>
</html>