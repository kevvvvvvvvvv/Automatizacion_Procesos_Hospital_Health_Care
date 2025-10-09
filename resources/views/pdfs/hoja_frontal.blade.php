<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Expediente Clínico - Hoja Frontal</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 2.5cm 2cm; 
            font-size: 11pt;
            color: #333;
        }


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

        .field-container {
            width: 100%;
        }

        .field-row {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 15px;
        }

        .field-row-checkbox {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .field {
            display: flex;
            flex-direction: column;
            border-bottom: 1px solid #999;
            padding-bottom: 2px;
        }

        .field-checkbox{
            display: flex;
            flex-direction: column;
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
            min-height: 1.2em; 
        }
        
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

        .checkbox-new{
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 20px
        }

        .mark {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 1px solid black;
            border-radius: 5px;
            text-align: center;
            line-height: 18px;
            font-weight: bold;
            font-size: 12px;
        }

    </style>
</head>
<body>

    <header class="header">
        <img src="{{ public_path('images/Logo_HC_1.png') }}" alt="Logo Hospital" class="logo">
        <div class="hospital-info">
            <p><strong>1</strong></p>
            <p><strong>PLAN DE AYUTLA 413 COL. REFORMA</strong></p>
            <p><strong> CUERNAVACA, MORELOS, C.P. 62260 TEL: 777 323 0371</strong></p>
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
                    <div class="data" id="direccion">
                        {{ "{$paciente->calle} {$paciente->numero_exterior}, {$paciente->cp} {$paciente->colonia}, {$paciente->municipio}, {$paciente->estado}, {$paciente->pais}" }}
                    </div>
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
                    <div class="data" id="medico">{{ $hojafrontal->medico->name ?? '' }}</div>
                </div>
            </div>
            
            <div class="field-row">
                <div class="field half-width">
                    <label for="especialidad">Especialidad:</label>
                    <div class="data" id="especialidad">{{ $hojafrontal->medico->especialidad ?? '' }}</div>
                </div>
                <div class="field half-width">
                    <label for="firma">Firma:</label>
                    <div class="data" id="firma"></div>
                </div>
            </div>

            <div style="display:flex; gap:20px;">
                <div class="checkbox-new">
                    Ingreso:
                    @if(!$estancia->estancia_anterior_id) 
                        <span class="mark">X</span>
                    @else
                         <span class="mark"></span>
                    @endif
                </div>
                
                <div class="checkbox-new">
                    Reingreso:
                    @if($estancia->estancia_anterior_id)
                        <span class="mark">X</span>
                    @else
                         <span class="mark"></span>
                    @endif
                </div>
            </div>


            <div style="display:flex; gap:20px; margin-bottom:10px">
                <div class="checkbox-new">
                    Particular:
                    @if($estancia->modalidad_ingreso == 'Particular') 
                        <span class="mark">X</span>
                    @else
                         <span class="mark"></span>
                    @endif
                </div>
                
                <div class="checkbox-new">
                    Compañía aseguradora:
                    @if($estancia->modalidad_ingreso != 'Particular') 
                        <span class="mark">X</span>
                    @else
                         <span class="mark"></span>
                    @endif
                </div>
            </div>

            <div class="field-row">
                <div class="field full-width">
                    @if($estancia->modalidad_ingreso != 'Particular')
                        <div class="data">{{$estancia->modalidad_ingreso}}</div>
                    @else
                        <div class="data"></div>
                    @endif
                </div>
            </div>
            <div class="field-row">
                <div class="full-width">
                    <label for="notas">Notas:</label>
                    <div class="data" id="notas" style="height: 80px;"><strong>{{ $hojafrontal->notas ?? '' }}</strong></div>
                </div>
            </div>


            <div class="field-row">
                <div class="field full-width">
                    <label for="familiar">Nombre del familiar responsable</label>
                    <div class="data" id="familair">{{$familiar_responsable->nombre_completo}}</div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>