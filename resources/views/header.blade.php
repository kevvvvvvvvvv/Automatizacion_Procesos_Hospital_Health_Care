<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { box-sizing: border-box; }
        body { font-family: Calibri, Arial, sans-serif; font-size: 10pt; color: #333; }
        
        .header-content {
            padding-left: 1cm;
            padding-right: 1cm;
            display: flex; 
            justify-content: space-between;
            align-items: center; 
            
            padding-bottom: 8px;
        }
        .info-container { flex-basis: 45%; }
        .logo-container {
            width: 150px;
            height: 60px; 
            margin-bottom: 5px;
        }

        .logo { 
            max-width: 100%;  
            max-height: 100%; 
            width: auto;      
            height: auto;     
        }
        .hospital-info { text-align: left; font-size: 8pt; line-height: 1.2; }
        .hospital-info p { margin: 0; }
        .identification-card {
            border: 1px solid #666; 
            padding: 8px 12px; 
            font-size: 9pt; 
            width: 55%;
            flex-shrink: 0;
        }
        .identification-card h2 { text-align: center; font-size: 10pt; margin: 0 0 8px 0; font-weight: bold; }
        .id-row { display: flex; justify-content: space-between; margin-bottom: 4px; align-items: baseline; }
        .id-field { display: flex; align-items: baseline; margin-right: 7px; }
        .id-field:last-child { margin-right: 0; }
        .id-label { font-weight: bold; margin-right: 5px; white-space: nowrap; }
        .id-value { border-bottom: 1px solid #333; flex-grow: 1; min-width: 50px; }
        .id-value.long { min-width: 200px; }
        .id-value.short { min-width: 30px; flex-grow: 0; width: 50px; }
    </style>
</head>
<body>
    <div class="header-content">
        <div class="info-container">
            
            <div class="logo-container">
                @if(isset($logoDataUri) && $logoDataUri)
                    <img src="{{ $logoDataUri }}" alt="Logo Hospital" class="logo">
                @endif
            </div>
             <div class="hospital-info">
                <p><strong>PLAN DE AYUTLA 413 COL. REFORMA</strong></p>
                <p><strong> CUERNAVACA, MORELOS, C.P. 62260 TEL: 777 323 0371</strong></p>
                <p>Licencia sanitaria No. 23-AM-17-007-0002</p>
                <p>Responsable Sanitario Dr. Juan Manuel Ahumada Trujillo.</p>
            </div>
        </div>

        <div class="identification-card">
            <h2>FICHA DE IDENTIFICACIÓN</h2>
            <div class="id-row">
                <div class="id-field">
                    <span class="id-label">Fecha:</span>
                    <span class="id-value">{{ $historiaclinica->formularioInstancia['fecha_hora'] }}</span> 
                </div>
            </div>
            <div class="id-row">
                 <div class="id-field" style="flex-grow: 1;"> 
                    <span class="id-label">Nombre:</span>
                    <span class="id-value long">{{ $paciente['nombre'] . " " .  $paciente['apellido_paterno'] . " " . $paciente['apellido_materno']}}</span>
                 </div>
            </div>
             <div class="id-row">
                 <div class="id-field">
                    <span class="id-label">Fecha de nacimiento:</span>
                    <span class="id-value">{{ \Carbon\Carbon::parse($paciente['fecha_nacimiento'])->format('Y-m-d') }}</span>
                 </div>
                 <div class="id-field">
                    <span class="id-label">Edad:</span>
                    <span class="id-value short">{{$paciente['age'] . " años"}}</span>
                 </div>
                  <div class="id-field">
                    <span class="id-label">Sexo:</span>
                    <span class="id-value short">{{$paciente['sexo']}}</span>
                  </div>
            </div>
            <div class="id-row">
                <div class="id-field" style="flex-grow: 1;">
                    <span class="id-label">Domicilio:</span>
                    <span class="id-value long">{{ $paciente['calle'] }} {{ $paciente['numero_exterior'] }}{{ $paciente['numero_interior'] ? ' Int. ' . $paciente['numero_interior'] : '' }}, {{ $paciente['colonia'] }}, {{ $paciente['municipio'] }}, {{ $paciente['estado'] }}, {{ $paciente['pais'] }}, C.P. {{ $paciente['cp'] }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

