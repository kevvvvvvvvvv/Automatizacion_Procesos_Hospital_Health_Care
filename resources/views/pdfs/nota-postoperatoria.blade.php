<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota postoperatoria</title>
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
            font-size: 18pt;
            margin-bottom: 20px;
        }

        h3 {
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

        .one-line{
            display: inline-block;
            padding-right: 10px;
        }

        .contenedor-flex {
            display: flex;
            gap: 10px;
        }

        .cosa-inicio,
        .cosa-fin {
            flex: 1;
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

        .texto-preformateado {
            white-space: pre-wrap;
            word-wrap: break-word; 
        }
    </style>
</head>
<body>
    <main>
        <h1>Nota postoperatoria</h1>
        <div class="section-content contenedor-flex">
            <p class="hora-inicio"><strong>Hora inicio operación:</strong> {{ $notaData->hora_inicio_operacion ? \Carbon\Carbon::parse($notaData->hora_inicio_operacion)->format('H:i') : 'N/A' }}</p>
            <p class="hora-fin"><strong>Hora término operación:</strong> {{ $notaData->hora_termino_operacion ? \Carbon\Carbon::parse($notaData->hora_termino_operacion)->format('H:i') : 'N/A' }}</p>
        </div>

        <div class="section-content">
            <p><strong>Diagnóstico preoperatorio:</strong> {{ $notaData->diagnostico_preoperatorio ?? 'Sin datos.' }}</p>
            <p><strong>Operación planeada:</strong> {{ $notaData->operacion_planeada ?? 'Sin datos.' }}</p>
            <p><strong>Operación realizada:</strong> {{ $notaData->operacion_realizada ?? 'Sin datos.' }}</p>
            <p><strong>Diagnóstico postoperatorio:</strong> {{ $notaData->diagnostico_postoperatorio ?? 'Sin datos.' }}</p>
            <p><strong>Descripción de la técnica quirúrgica:</strong>{{ $notaData->descripcion_tecnica_quirurgica ?? 'Sin datos.' }}</p>
            <p><strong>Hallazgos transoperatorios:</strong>{{ $notaData->hallazgos_transoperatorios ?? 'Sin datos.' }}</p>
            <p><strong>Reporte del conteo de gasas, compresas y de instrumental quirúrgico:</strong> {{ $notaData->reporte_conteo ?? 'Sin datos.' }}</p>
            <p><strong>Incidentes y accidentes:</strong> {{ $notaData->incidentes_accidentes ?? 'Sin datos.' }}</p>
            <p><strong>Cuantificación de sangrado:</strong> {{ $notaData->cuantificacion_sangrado . ' mililitros.' ?? 'Sin datos.' }}</p>

            <p><strong>Transfusiones:</strong> 
                @foreach ($notaData->transfusiones ?? [] as $transfusion )
                    {{ $transfusion->tipo_transfusion . ' '}} <strong> cantidad:  </strong>{{ $transfusion->cantidad}}
                    @if (!$loop->last)
                        ,
                    @elseif ($loop->last)
                        .
                    @endif
                @endforeach
            </p>

            <p><strong>Estudios de servicios auxiliares de diagnóstico y tratamiento transoperatorios:</strong> {{ $notaData->estudios_transoperatorios ?? 'Sin datos.' }}</p>

        </div>

        @php
            $personalColeccion = $notaData->personalEmpleados ?? collect([]);
            $getNombresPorCargo = function ($cargo) use ($personalColeccion) {
                return $personalColeccion
                    ->where('cargo', $cargo)
                    ->map(fn($p) => $p->user->nombre . ' ' . $p->user->apellido_paterno . ' ' . $p->user->apellido_materno)
                    ->implode(', ');
            };

            $listaAyudantes = $getNombresPorCargo('ayudante');
            $listaInstrumentistas = $getNombresPorCargo('instrumentista');
            $listaAnestesistas = $getNombresPorCargo('anestesiologo');
            $listaCirculantes = $getNombresPorCargo('circulante');
        @endphp
        @if (!empty($listaAyudantes) || !empty($listaInstrumentistas) || !empty($listaAnestesistas) || !empty($listaCirculantes))
            <p>
                <strong>Ayudantes, instrumentistas, anestesiólogo y circulante:</strong>

                @if (!empty($listaAyudantes))
                    <strong>Ayudantes:</strong> {{ $listaAyudantes }}. 
                @endif

                @if (!empty($listaInstrumentistas))
                    <strong>Instrumentistas:</strong> {{ $listaInstrumentistas }}. 
                @endif

                @if (!empty($listaAnestesistas))
                    <strong>Anestesiólogos:</strong> {{ $listaAnestesistas }}. 
                @endif

                @if (!empty($listaCirculantes))
                    <strong>Circulante:</strong> {{ $listaCirculantes }}. 
                @endif
            </p>
        @endif
            
        <div>
            <p><strong>Estado post-quirúrgico inmediato:</strong> {{ $notaData->estado_postquirurgico ?? 'Sin datos.' }}</p>

            <h3>Plan de manejo y tratamiento postoperatorio inmediato</h3>

            <strong>Dieta:</strong>
            <div className="texto-preformateado">
                {{ $notaData->manejo_dieta ?? 'Sin datos.' }}
            </div>
            <strong>Soluciones:</strong>
            <div className="texto-preformateado">
                {{ $notaData->manejo_soluciones ?? 'Sin datos.' }}
            </div>
            <strong>Medicamentos:</strong>
            <div className="texto-preformateado">
                {{ $notaData->manejo_medicamentos ?? 'Sin datos.' }}
            </div>
            <strong>Medidas generales:</strong>
            <div className="texto-preformateado">
                {{ $notaData->manejo_medidas_generales ?? 'Sin datos.' }}
            </div>
            <strong>Laboratorios y gabinete:</strong>
            <div className="texto-preformateado">
                {{ $notaData->manejo_laboratorios ?? 'Sin datos.' }}
            </div>
            <h3></h3>
            <p><strong>Pronóstico:</strong> {{ $notaData->pronostico ?? 'Sin datos.' }}</p>


            <p><strong>Envío de piezas o biopsias quirúrgicas para examen macroscópico e histopatológico:</strong> </p>
            <div className="texto-preformateado">
                {{ $notaData->envio_piezas ?? 'Sin datos.' }}
            </div>



            <p><strong>Otros hallazgos de importancia para el paciente, relacionados con el quehacer médico:</strong>
            {{ $notaData->hallazgos_importancia ?? 'Sin datos.' }}</p>

        </div>

        @if(isset($medico))
            <div class="signature-section">
                <div class="signature-line"></div>
                <p>{{ $medico->nombre . " " . $medico->apellido_paterno . " " . $medico->apellido_materno}}</p>
                <p style="font-size: 9pt; color: #555;">Nombre y Firma del Médico</p>

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
       
    </main>
</body>
</html>

