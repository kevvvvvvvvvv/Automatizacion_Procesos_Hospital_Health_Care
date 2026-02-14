<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de exámenes {{$notaData->id}}</title>
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

        h1 {
            text-align: center;
            font-size: 18pt;
            margin-bottom: 20px;
        }

        h2 {
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
    <h1>Solicitud de exámenes</h1>
    
    <section class='solicitud-envio'>
        <p><strong>Fecha: </strong> {{ $notaData->created_at->format('d/m/Y H:i') }}</p>

        @php $paciente = $notaData->formularioInstancia->estancia->paciente; @endphp
        <p><strong>Paciente: </strong> {{ $paciente->nombre }} {{ $paciente->apellido_paterno }} {{$paciente->apellido_materno}}</p>


        <p><strong>Médico solicitante: </strong> {{ $notaData->userSolicita->nombre }} {{ $notaData->userSolicita->apellido_paterno }} {{ $notaData->userSolicita->apellido_paterno }}</p>
    </section>

    <section class='solcitud-estudios'>
        <h3>Exámenes solicitados:</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Estudio</th>
                    <th>Departamento</th>
                    <th>Detalles / Especificaciones</th>
                    <th>Estado</th>
                    <th>Resultados</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notaData->solicitudItems as $item)
                    <tr>
                        <td>
                            @if($item->catalogoEstudio)
                                {{ $item->catalogoEstudio->nombre }}
                            @else
                                {{ $item->otro_estudio }} (No registrado en los estudios)
                            @endif
                        </td>
                        <td>
                            {{ $item->catalogoEstudio->departamento ?? 'N/A' }}
                        </td>
                        <td>
                            @php
                                $detallesJson = $item->detalles; 
                                $miDetalle = null;
                                
                                if (is_array($detallesJson) && $item->catalogo_estudio_id) {
                                    $miDetalle = $detallesJson[$item->catalogo_estudio_id] ?? null;
                                }
                            @endphp

                            @if($miDetalle)
                                <div class="detalle-texto">
                                    Modalidad: {{ $miDetalle['modalidad'] ?? '' }}
                                    @if(isset($miDetalle['via']) && $miDetalle['via'])
                                        <br> Vía: {{ $miDetalle['via'] }}
                                    @endif
                                    @if(isset($miDetalle['especificacion']) && $miDetalle['especificacion'])
                                        <br> Nota: {{ $miDetalle['especificacion'] }}
                                    @endif
                                </div>
                            @else
                                <div>N/A</div>
                            @endif
                        </td>
                        <td>{{$item->estado}}</td>
                        <td>
                            @if($item->ruta_archivo_resultado)
                                <a href="{{ asset('storage/' . $item->ruta_archivo_resultado) }}" 
                                target="_blank" 
                                class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 text-xs font-bold rounded-md bg-white hover:bg-blue-100 transition duration-150 ease-in-out">
                                    Visualizar resultados (PDF)
                                </a>
                            @else
                                <p class="text-gray-300 italic"> No se han cargado resultados</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <p><strong>Resultados: </strong>Los resultados se encuentran en este documento</p>
   
    @if(isset($medico))
        <div class="signature-section">
            <div class="signature-line"></div>
            <p style="font-size: 9pt; color: #555;">Nombre completo, cédula profesional y firma del médico</p>
            <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno}}</p>
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
</body>
</html>