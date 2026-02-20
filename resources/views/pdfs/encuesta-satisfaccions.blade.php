<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encuesta de satisfacción</title>
    <style>
        console.log("comenatario de que si llego");
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
        <h1>Encuesta de satisfacción</h1>

        <div class="section-content">
            <p><strong>Ateción en recepción: </strong> {{ $notaData->atencion_recpcion ?? 'Sin datos.' }}</p>
            <p><strong>Trato dek personal de enfermeria: </strong> {{ $notaData->trato_personal_enfermeria ?? 'Sin datos.' }}</p>
            <p><strong>Limpieza y comodidad de la habotación: </strong> {{ $notaData->limpieza_comodidad_habitacion ?? 'Sin datos.' }}</p>
            <p><strong>Calidad de comida: </strong> {{ $notaData->calidad_comida ?? 'Sin datos.' }}</p>
            <p><strong>Tiempo de espera en tu ateción médica: </strong>{{ $notaData->tiempo_atencion ?? 'Sin datos.' }}</p>
            <p><strong>¿Te sentiste bien informado(a) sobre tu procedimiento: </strong>{{ $notaData->informacion_tratamiento  ?? 'Sin datos.' }}</p>
            <p><strong>¿Recibió atención nutricional?: </strong> {{ $notaData->atencion_nutricional ?? 'Sin datos.' }}</p>
            <p><strong>Comentarios: </strong> {{ $notaData->comentarios ?? 'Sin datos.' }}</p>
            <p><strong>¡Gracias por ayudarnos a mejorar! </strong></p>
        </div>



       
    </main>
</body>
</html>

