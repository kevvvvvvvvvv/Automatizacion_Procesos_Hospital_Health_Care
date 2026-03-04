<!DOCTYPE html>
<html>
<head>
    <style>
        .receta-container { font-family: sans-serif; padding: 20px; }
        .titulo { text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 20px; }
        .contenido { font-size: 14px; line-height: 1.6; min-height: 300px; }
        .firma { margin-top: 50px; text-align: center; }
    </style>
</head>
<body>
    <div class="receta-container">
        <div class="titulo">RECETA MÉDICA / TRATAMIENTO</div>
        
        <p><strong>Paciente:</strong> {{ $paciente->nombre_completo ?? $paciente->nombre }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y H:i') }}</p>
        
        <hr>
        
        <div class="contenido">
            <strong>Indicaciones y Tratamiento:</strong><br>
            {!! nl2br(e($tratamiento)) !!}
        </div>

        <div class="firma">
            <br><br>
            __________________________<br>
            Dr. {{ $medico->name }}<br>
            {{ $medico->credenciales->cedula ?? '' }}
        </div>
    </div>
</body>
</html>