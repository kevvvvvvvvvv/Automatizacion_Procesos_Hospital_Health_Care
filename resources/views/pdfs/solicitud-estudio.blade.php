<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Exámenes</title>
    <style>
        body { font-family: sans-serif; }
        @page { margin: 2cm; }
        .header { margin-bottom: 20px; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .items-table th, .items-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .items-table th { background-color: #f2f2f2; }
        .detalle-texto { font-size: 0.85em; color: #555; font-style: italic; }
    </style>
</head>
<body>
    <h1>Solicitud de exámenes</h1>
    
    <section class='solicitud-envio'>
        <p><strong>Fecha: </strong> {{ $solicitud->created_at->format('d/m/Y H:i') }}</p>

        @php $paciente = $solicitud->formularioInstancia->estancia->paciente; @endphp
        <p><strong>Paciente: </strong> {{ $paciente->nombre }} {{ $paciente->apellido_paterno }} {{$paciente->apellido_materno}}</p>


        <p><strong>Médico solicitante: </strong> {{ $solicitud->userSolicita->nombre }} {{ $solicitud->userSolicita->apellido_paterno }} {{ $solicitud->userSolicita->apellido_paterno }}</p>
    </section>

    <section class='solcitud-estudios'>
        <h3>Exámenes solicitados:</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Estudio</th>
                    <th>Departamento</th>
                    <th>Detalles / Especificaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($solicitud->solicitudItems as $item)
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>
</html>