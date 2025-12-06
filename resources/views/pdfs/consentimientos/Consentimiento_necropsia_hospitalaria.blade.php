<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consentimiento Informado Necropsia hospitalaria</title>
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
        <h1>Consentimiento informado Necropsia hospitalaria</h1> 

        <h3>Encabezado</h3>
        <div class="section-content">
            <p>Razón social: S.A de C.V></p>
            <p>CUERNAVACA, MORELOS. C.P. 62260 TEL: 777 323 0371</p>
            <p>Licencia sanitaria No. 23-AM-17-007-0002</p>
            <p>Responsable Sanitario Dr. Juan Manuel Ahumada Trujillo.</p>
        </div>
        {{-- Sección del cuerpo del consentimiento--}}
        <div class="Section-content">
            <p> </p>
        </div>    
        
        {{-- sECCIÓN DE LAS FIRMAS--}}
        <div class="signature-section">
            <div class="signature-line"></div>
            <p>{{$paciente->nombre ?? 'Sin datos'}}</p>
            <p style="font-size: 9pt; color:#555;"> Nombre y firmadel paciente</p>
            <div class="signature-line"></div>
            <p>{{$paciente->familiar_responsable ?? " "}} </p>
            <p style="font-size: 9pt; color:#555;"> Nombre y firma del familiar responsable</p>
            <div class="signature-line"></div>
            <p style="font-size: 9pt; color:#555;">Testigo</p> 
            <div class="signature-line"></div>
            <p style="font-size: 9pt; color:#555;">Testigo</p>
        </div>      
        
        {{-- SECCIÓN DE FIRMA DEL MÉDICO (si aplica) --}}
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