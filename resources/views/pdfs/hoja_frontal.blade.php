<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expediente Clínico - Hoja Frontal</title>
    <style>
        /* Usamos A4 para un estándar de impresión común */
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 2.5cm 2cm; /* Márgenes generosos como en el documento */
            font-size: 11pt;
            color: #333;
        }

        /* --- HEADER --- */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header .logo {
            width: 180px;
        }

        .header .hospital-info {
            text-align: right;
            font-size: 9pt;
        }
        .header .hospital-info p {
            margin: 0;
            line-height: 1.4;
        }

        /* --- TÍTULOS --- */
        .main-title {
            text-align: center;
            margin: 30px 0;
        }
        .main-title h1 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
        }
        .main-title h2 {
            margin: 5px 0 0 0;
            font-size: 14pt;
            font-weight: normal;
            display: inline-block;
            border-bottom: 1px solid #333;
            padding-bottom: 2px;
        }

        /* --- CONTENEDOR DE CAMPOS --- */
        .field-container {
            width: 100%;
        }

        .field-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 15px;
        }

        .field {
            display: flex;
            flex-direction: column;
            border-bottom: 1px solid #999;
            padding-bottom: 2px;
        }
        .field.full-width {
            width: 100%;
        }
        .field.half-width {
            width: 48%;
        }
        .field.third-width {
            width: 32%;
        }

        .field label {
            font-size: 9pt;
            margin-bottom: 4px;
        }
        .field .data {
            font-weight: bold;
            min-height: 1.2em; /* Para que la línea no desaparezca si no hay dato */
        }
        
        /* --- CHECKBOXES --- */
        .checkbox-area {
            display: flex;
            align-items: center;
            font-size: 11pt;
        }
        .checkbox {
            width: 18px;
            height: 18px;
            border: 1px solid #333;
            margin-right: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        /* --- NOTAS --- */
        .notes {
            margin-top: 20px;
        }

    </style>
</head>
<body>

    <header class="header">
        {{-- 🔧 AJUSTA AQUÍ: Cambia la ruta a tu logo. Usa una ruta absoluta. --}}
        <img src="{{ public_path('images/logo.png') }}" alt="Logo Hospital" class="logo">
        <div class="hospital-info">
            <p><strong>PLAN DE AYUTLA 413 COL. REFORMA</strong></p>
            <p>CUERNAVACA, MORELOS, C.P. 62260 TEL: 777 323 0371</p>
            <p>Licencia sanitaria No. 23-AM-17-007-0002</p>
            <p>Responsable Sanitario Dr. Juan Manuel Ahumada Trujillo.</p>
        </div>
    </header>

    <main>
        <div class="main-title">
            <h1>EXPEDIENTE CLÍNICO</h1>
            <h2>Hoja Frontal</h2>
        </div>

        <div class="field-container">
            <div class="field-row">
                <div class="field full-width">
                    <label for="nombre">Nombre del paciente:</label>
                    <div class="data" id="nombre">{{ $paciente->nombre ?? '' }} {{ $paciente->apellido_paterno ?? '' }} {{ $paciente->apellido_materno ?? '' }}</div>
                </div>
            </div>

            <div class="field-row">
                <div class="field third-width">
                    <label for="edad">Edad:</label>
                    {{-- La edad se calcula a partir de la fecha de nacimiento --}}
                    <div class="data" id="edad">{{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age : '' }}</div>
                </div>
                <div class="field third-width">
                    <label for="sexo">Sexo:</label>
                    <div class="data" id="sexo">{{ $paciente->sexo ?? '' }}</div>
                </div>
                <div class="field third-width">
                    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                    <div class="data" id="fecha_nacimiento">{{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') : '' }}</div>
                </div>
            </div>

            <div class="field-row">
                <div class="field full-width">
                    <label for="direccion">Dirección:</label>
                    <div class="data" id="direccion">{{ $paciente->direccion ?? '' }}</div>
                </div>
            </div>

            <div class="field-row">
                <div class="field half-width">
                    <label for="telefono">Teléfono(s):</label>
                    <div class="data" id="telefono">{{ $paciente->telefono ?? '' }}</div>
                </div>
                <div class="field half-width">
                    <label for="fecha_ingreso">Fecha de ingreso:</label>
                    <div class="data" id="fecha_ingreso">{{ $estancia->fecha_ingreso ? \Carbon\Carbon::parse($estancia->fecha_ingreso)->format('d/m/Y') : '' }}</div>
                </div>
            </div>

            <div class="field-row">
                 <div class="field full-width">
                    <label for="medico">Médico tratante:</label>
                    {{-- Asumiendo que la hoja frontal tiene relación con el médico (User) --}}
                    <div class="data" id="medico">{{ $hojafrontal->medico->name ?? '' }}</div>
                </div>
            </div>
            
            <div class="field-row">
                <div class="field half-width">
                    <label for="especialidad">Especialidad:</label>
                     {{-- 🔧 AJUSTA AQUÍ: Asumiendo que tu modelo User (medico) tiene un campo 'especialidad' --}}
                    <div class="data" id="especialidad">{{ $hojafrontal->medico->especialidad ?? '' }}</div>
                </div>
                <div class="field half-width">
                    <label for="firma">Firma:</label>
                    <div class="data" id="firma"></div>
                </div>
            </div>
            
            <div class="field-row">
                <div class="field half-width checkbox-area">
                    <div class="checkbox">
                        {{-- 🔧 AJUSTA AQUÍ: La lógica para marcar la casilla (ej. $estancia->tipo == 'Ingreso') --}}
                        @if(true) X @endif
                    </div>
                    Ingreso
                    <div class="checkbox" style="margin-left: 20px;">
                        @if(false) X @endif
                    </div>
                    Reingreso
                </div>
                <div class="field half-width checkbox-area">
                     <div class="checkbox">
                        @if(true) X @endif
                    </div>
                    Particular
                    <div class="checkbox" style="margin-left: 20px;">
                         @if(false) X @endif
                    </div>
                    Compañía aseguradora
                </div>
            </div>

            <div class="field-row notes">
                <div class="field full-width">
                    <label for="notas">Notas:</label>
                    <div class="data" id="notas" style="height: 80px;">{{ $hojafrontal->notas ?? '' }}</div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>