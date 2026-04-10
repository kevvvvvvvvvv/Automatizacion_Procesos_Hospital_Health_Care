<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consentimiento de alta voluntaria</title>
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
        
        .headerConsentimiento {
            display: flex; 
            justify-content: space-between;
            align-items: center; 
            padding-bottom: 8px;
            margin-bottom: 15px; 
        }

        .headerConsentimiento .info-container {
            flex-basis: 45%; 
        }

        .headerConsentimiento .logo {
            width: 150px; 
            display: block; 
            margin-bottom: 5px;
        }

        .headerConsentimiento .hospital-info { 
             text-align: left; 
             font-size: 8pt; 
             line-height: 1.2;
        }
        .headerConsentimiento .hospital-info p {
             margin: 0;
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
    <main>
        <h1>Consentimiento de alta voluntaria</h1>
            <h3>Cuerpo del consentimiento</h3>
            <p style="text-align: right;">
                Cuernavaca, Morelos, a <strong>{{ $fecha['dia'] }}</strong> de <strong>{{ $fecha['mes'] }}</strong> del <strong>{{ $fecha['anio'] }}</strong>. 
            </p>
            <p>
                El que suscribe _________________________________________________________
                en mi caracter de ______________, presentando indentificación oficial ______________.
            </p> 
            <p>
                Solicito <strong class="important"> Alta voluntaria</strong> de <strong>{{ $paciente->nombre_completo ?? '____________________' }}</strong>,
                por el(los) siguiente(s) motivo(s):
                ______________________________________________________________________________________________________
                ______________________________________________________________________________________________________
                ______________________________________________________________________________________________________
                Conociendo de ante mano el estado de salud y los riesgos del paciente.
            </p>
            <p>
                Una vez firmado el presente, eximo a Hospitalidad Health Care, su personal médico 
                y administrativo de toda responsabilidad sobre el paciente.
    
    <style>
    .table-signatures {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table-signatures td {
        width: 33%;
        vertical-align: top;
        text-align: center;
        padding: 10px;
    }

    .signature-line {
        width: 100%;
        height: 1px;
        background-color: #000;
        margin: 20px auto 5px auto;
    }
    </style>        
        <table class="table-signatures">

    {{-- FILA 1 --}}
    <tr>

        {{-- 1. Paciente --}}
        <td>
            <div class="signature-line"></div>
            <p>{{ $paciente->nombre_completo ?? '' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y firma del paciente</p>
        </td>

        {{-- 2. Familiar responsable --}}
        <td>
            <div class="signature-line"></div>
            <p>{{ $estancia->familiarResponsable->nombre_completo ?? '' }}</p>
            <p style="font-size: 9pt; color: #555;">Nombre y firma del familiar responsable</p>
        </td>

        {{-- 3. Testigo 1 --}}
       

    </tr>

    {{-- FILA 2 --}}
    <tr>

        {{-- 4. Testigo 2 --}}
        <td>
            <div class="signature-line"></div>
            <p>Nombre y firma de testigo</p>
        </td>

         <td>
            <div class="signature-line"></div>
            <p>Nombre y firma de testigo</p>
        </td>

    </tr>

</table>

</div>
</main>
</body>    