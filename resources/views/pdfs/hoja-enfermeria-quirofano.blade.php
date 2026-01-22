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

        h3 {
            background-color: #f2f2f2;
            padding: 5px;
            margin-top: 15px;
            margin-bottom: 5px;
            border-bottom: 2px solid #ccc;
            font-size: 11pt;
            text-transform: uppercase;
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
    </style>
</head>

<body>
    <h1>Hoja de enfermería en quirófano</h1>
    
    <div style="text-align: right; font-size: 8pt; margin-bottom: 10px;">
        <strong>Fecha:</strong> {{ date('d/m/Y', strtotime($notaData['created_at'])) }}
    </div>

    <h3>Tiempos Quirúrgicos</h3>
    <table class="info-table">
        <tr>
            <td><strong>Inicio Anestesia:</strong> {{ $notaData['hora_inicio_anestesia'] ?? '--:--' }}</td>
            <td><strong>Fin Anestesia:</strong> {{ $notaData['hora_fin_anestesia'] ?? '--:--' }}</td>
            <td><strong>Inicio Cirugía:</strong> {{ $notaData['hora_inicio_cirugia'] ?? '--:--' }}</td>
        </tr>
        <tr>
            <td><strong>Fin Cirugía:</strong> {{ $notaData['hora_fin_cirugia'] ?? '--:--' }}</td>
            <td><strong>Ingreso Paciente:</strong> {{ $notaData['hora_inicio_paciente'] ?? '--:--' }}</td>
            <td><strong>Salida Paciente:</strong> {{ $notaData['hora_fin_paciente'] ?? '--:--' }}</td>
        </tr>
    </table>

    <div class="clearfix">
        <div style="width: 48%; float: left; margin-right: 2%;">
            <h3>Tipo de Anestesia</h3>
            <div>
                @foreach($notaData['anestesia'] as $key => $valor)
                    <div style="margin-bottom: 3px;">
                        <span class="check-box {{ $valor ? 'checked' : '' }}"></span>
                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                    </div>
                @endforeach
            </div>
        </div>

        <div style="width: 48%; float: left;">
            <h3>Servicios Especiales</h3>
            <div>
                @foreach($notaData['servicios_especiales'] as $key => $valor)
                    <div style="margin-bottom: 3px;">
                        <span class="check-box {{ $valor ? 'checked' : '' }}"></span>
                        {{ ucfirst(str_replace('_', ' ', $key)) }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <h3>Personal en Sala</h3>
    <table class="list-table">
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
                        {{-- Accedemos a la relación 'user' dentro del array --}}
                        {{ $personal['user']['name'] ?? 'ID: ' . $personal['user_id'] }} 
                        {{ $personal['user']['apellido_paterno'] ?? '' }}
                        {{ $personal['user']['apellido_materno'] ?? '' }}
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">No se registró personal</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Control de Oxígeno</h3>
    <table class="list-table">
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
                <tr><td colspan="5" class="text-center">No se registró consumo de oxígeno</td></tr>
            @endforelse
        </tbody>
    </table>

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