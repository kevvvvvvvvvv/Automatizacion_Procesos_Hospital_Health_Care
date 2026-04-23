<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hoja de Enfermería Recién Nacido</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: sans-serif; font-size: 9pt; line-height: 1.2; color: #333; }
        
        /* Encabezado Estilo Hospitalario */
        .header { width: 100%; border-bottom: 2px solid #000; margin-bottom: 10px; padding-bottom: 5px; }
        .header table { width: 100%; }
        .title { text-align: center; font-weight: bold; font-size: 14pt; text-transform: uppercase; }
        
        /* Información General */
        .info-section { width: 100%; margin-bottom: 15px; border: 1px solid #ccc; padding: 5px; background-color: #f9f9f9; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 2px 5px; }
        .label { font-weight: bold; text-transform: uppercase; font-size: 8pt; }

        /* Estilo de Tablas de Datos */
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; table-layout: fixed; }
        table.data-table th, table.data-table td { border: 1px solid #000; padding: 3px; text-align: center; font-size: 8pt; word-wrap: break-word; }
        table.data-table th { background-color: #e2e2e2; font-weight: bold; text-transform: uppercase; }
        
        .section-title { background-color: #2c3e50; color: white; padding: 5px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; font-size: 10pt; }

        /* Colores específicos para balance */
        .text-green { color: green; font-weight: bold; }
        .text-red { color: red; font-weight: bold; }

        footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 7pt; border-top: 1px solid #ccc; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <table>
            <tr>
                <td width="20%">[LOGO HOSPITAL]</td>
                <td width="60%" class="title">Hoja de Enfermería Recién Nacido</td>
                <td width="20%" style="text-align: right;">Folio: {{ $hoja->id }}</td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td class="label">Nombre RN:</td><td>{{ $hoja->nombre_rn }}</td>
                <td class="label">Sexo:</td><td>{{ $hoja->sexo }}</td>
                <td class="label">Fecha Nac:</td><td>{{ \Carbon\Carbon::parse($hoja->fecha_rn)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Madre:</td><td>{{ $paciente->nombre_completo }}</td>
                <td class="label">Área:</td><td>{{ $hoja->area }}</td>
                <td class="label">Peso Nac:</td><td>{{ $hoja->peso }} kg</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Signos Vitales</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha/Hora</th>
                <th>T.A. (mmHg)</th>
                <th>F.C. (ppm)</th>
                <th>F.R. (rpm)</th>
                <th>Temp (°C)</th>
                <th>S.O2 (%)</th>
                <th>G.C. (mg/dL)</th>
                <th>Peso (kg)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($signos as $s)
            <tr>
                <td>{{ \Carbon\Carbon::parse($s->fecha_hora_registro)->format('d/m H:i') }}</td>
                <td>{{ $s->tension_arterial_sistolica }}/{{ $s->tension_arterial_diastolica }}</td>
                <td>{{ $s->frecuencia_cardiaca }}</td>
                <td>{{ $s->frecuencia_respiratoria }}</td>
                <td>{{ $s->temperatura }}</td>
                <td>{{ $s->saturacion_oxigeno }}</td>
                <td>{{ $s->glucemia_capilar }}</td>
                <td>{{ $s->peso }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Somatometría y Valoración Neonatal</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha/Hora</th>
                <th>P. Cefálico</th>
                <th>P. Torácico</th>
                <th>P. Abdom.</th>
                <th>Pie</th>
                <th>Capurro</th>
                <th>APGAR</th>
                <th>Silverman</th>
            </tr>
        </thead>
        <tbody>
            @foreach($somatometrias as $som)
            <tr>
                <td>{{ \Carbon\Carbon::parse($som->created_at)->format('d/m H:i') }}</td>
                <td>{{ $som->perimetro_cefalico }} cm</td>
                <td>{{ $som->perimetro_toracico }} cm</td>
                <td>{{ $som->perimetro_abdominal }} cm</td>
                <td>{{ $som->pie }} cm</td>
                <td>{{ $som->capurro }} sem</td>
                <td>{{ $som->apgar }}</td>
                <td>{{ $som->silverman }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Medicamentos</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Medicamento</th>
                <th>Dosis</th>
                <th>Vía</th>
                <th>Frecuencia</th>
                <th>Horarios de Aplicación (Fecha/Hora)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicamentos as $med)
            <tr>
                <td>{{ $med->productoServicio->nombre_prestacion }}</td>
                <td>{{ $med->dosis }}</td>
                <td>{{ $med->via }}</td>
                <td>{{ $med->frecuencia }}</td>
                <td>
                    @foreach($med->aplicaciones as $app)
                        {{ \Carbon\Carbon::parse($app->fecha_hora_aplicacion)->format('d/m H:i') }}@if(!$loop->last), @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Soluciones y Terapias IV</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Solución / Mezcla</th>
                <th>Volumen</th>
                <th>Goteo/Velocidad</th>
                <th>Instalación</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($terapias as $ter)
            <tr>
                <td>
                    @foreach($ter->detalleSoluciones as $sol)
                        {{ $sol->solucion->nombre_prestacion }} ({{ $sol->cantidad }}ml) @if(!$loop->last) + @endif
                    @endforeach
                </td>
                <td>{{ $ter->volumen_total }} ml</td>
                <td>{{ $ter->velocidad_infusion }} ml/h</td>
                <td>{{ \Carbon\Carbon::parse($ter->fecha_hora_instalacion)->format('d/m H:i') }}</td>
                <td>{{ $ter->observaciones }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Control de Líquidos (Ingresos y Egresos)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Fecha/Hora</th>
                <th>Seno Mat.</th>
                <th>Fórmula</th>
                <th>Otros Ing.</th>
                <th>Micción</th>
                <th>Evac.</th>
                <th>Emesis</th>
                <th>Balance Parcial</th>
            </tr>
        </thead>
        <tbody>
            @foreach($liquidos as $liq)
            <tr>
                <td>{{ \Carbon\Carbon::parse($liq->created_at)->format('d/m H:i') }}</td>
                <td>{{ $liq->seno_materno ?: '-' }}</td>
                <td>{{ $liq->formula ? $liq->formula.' ml' : '-' }}</td>
                <td>{{ $liq->cantidad_ingresos ? $liq->otros_ingresos.': '.$liq->cantidad_ingresos.'ml' : '-' }}</td>
                <td>{{ $liq->miccion ?: '-' }}</td>
                <td>{{ $liq->evacuacion ?: '-' }}</td>
                <td>{{ $liq->emesis ? $liq->emesis.' ml' : '-' }}</td>
                <td class="{{ $liq->balance_total >= 0 ? 'text-green' : 'text-red' }}">
                    {{ $liq->balance_total }} ml
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <strong>Observaciones Generales:</strong>
        <p style="border: 1px solid #ccc; padding: 10px; min-height: 50px;">{{ $hoja->observaciones }}</p>
    </div>

    <footer>
        Impreso por: {{ Auth::user()->name }} - Fecha: {{ now()->format('d/m/Y H:i') }} - Registro generado mediante el Sistema ECE
    </footer>

</body>
</html>