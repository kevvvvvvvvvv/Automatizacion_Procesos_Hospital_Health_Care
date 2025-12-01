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
            <p><strong>CALLE PLAN DE AYUTLA NÚMERO 13 COLONIA REFORMA</strong></p>
            <p><strong>CUERNAVACA, MORELOS, CÓDIGO POSTAL 62260 TÉLEFONO 777 323 0371</strong></p>
            <p>Licencia sanitaria número 23-AM-17-007-0002</p>
            <p>Responsable Sanitario Dr. Juan Manuel Ahumada Trujillo.</p>
        </div>
    </header>

    <main>
        <div class="main-title">
            <h1>Envio de pieza patológica</h1>
        </div>
        <div>
            <p><strong>Contenedores enviados: </strong></p>
            <p><strong>Estudio solicitado: </strong>{{$notaData['estudio_solicitado']}}</p>
            <p><strong></strong>{{$notaData['biopsia_pieza_quirurgica']}}</p>
            <p><strong>Revision de laminillas: </strong>{{$notaData['revision_laminillas']}}</p>
            <p><strong>Estudios especiales: </strong>{{$notaData['estudios_especiales']}}</p>
            <p><strong>PCR: </strong>{{$notaData['pcr']}}</p>
            <p><strong>Pieza remitida: </strong>{{$notaData['pieza_remitida']}}</p>
            <p><strong>Datos clinicos: </strong>{{$notaData['datos_clinicos']}}</p>
            <p><strong>Empresa a enviar: </strong>{{$notaData['empresa_enviar']}}</p>
            <p><strong>Resultados: </strong>{{$notaData['resultados']}}</p>
            <p><strong>Detalles: </strong></p>
        </div>
    </main>

</body>
</html>