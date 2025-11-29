<style>
    /* Solo estilos, nada de etiquetas html o body envolventes */
    .header-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Calibri, Arial, sans-serif;
        font-size: 10pt;
        color: #333;
    }
    .col-left {
        width: 45%;
        vertical-align: top;
        padding-right: 10px;
    }
    .col-right {
        width: 55%;
        vertical-align: top;
    }
   
    /* Logo e Info */
    .logo-img {
        max-width: 150px;
        height: auto;
        display: block;
        margin-bottom: 5px;
    }
    .hospital-info p {
        margin: 0;
        font-size: 8pt;
        line-height: 1.2;
    }

    /* Ficha Identificación (Simulando tu diseño original) */
    .ficha-box {
        border: 1px solid #666;
        padding: 5px;
        font-size: 9pt;
    }
    .ficha-title {
        text-align: center;
        font-weight: bold;
        margin: 0 0 5px 0;
        font-size: 10pt;
        display: block;
    }
   
    /* Tabla interna para los datos del paciente */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table td {
        padding-bottom: 3px;
        vertical-align: bottom;
    }
    .label {
        font-weight: bold;
        padding-right: 5px;
        white-space: nowrap;
    }
    .value {
        border-bottom: 1px solid #333;
        width: 100%; /* Ocupa el espacio restante */
    }
    .value-text {
        padding-left: 2px;
    }
</style>

<!-- Usamos una tabla principal para dividir izquierda y derecha -->
<table class="header-table">
    <tr>
        <!-- Columna Izquierda: Logo e Info -->
        <td class="col-left">
            @if(isset($logoDataUri) && $logoDataUri)
                <img src="{{ $logoDataUri }}" alt="Logo" class="logo-img">
            @endif
           
            <div class="hospital-info">
                <p><strong>CALLE PLAN DE AYUTLA NÚMERO 13 COLONIA REFORMA</strong></p>
                <p><strong>CUERNAVACA, MORELOS, CP 62260 TÉL 777 323 0371</strong></p>
                <p>Licencia sanitaria número 23-AM-17-007-0002</p>
                <p>Resp. Sanitario Dr. Juan Manuel Ahumada Trujillo.</p>
            </div>
        </td>

        <!-- Columna Derecha: Ficha -->
        <td class="col-right">
            <div class="ficha-box">
                <div class="ficha-title">FICHA DE IDENTIFICACIÓN</div>
               
                <!-- Tabla interna para alinear campos -->
                <table class="data-table">
                    <!-- Fila 1: Fecha y Folio -->
                    <tr>
                        <td width="1%" class="label">Fecha:</td>
                        <td width="40%" class="value"><span class="value-text">{{ $historiaclinica->formularioInstancia['fecha_hora'] ?? '' }}</span></td>
                        <td width="5%"></td> <!-- Espaciador -->
                        <td width="1%" class="label">Folio:</td>
                        <td class="value"><span class="value-text">{{$estancia['folio'] ?? ''}}</span></td>
                    </tr>
                </table>

                <table class="data-table">
                    <!-- Fila 2: Nombre -->
                    <tr>
                        <td width="1%" class="label">Nombre:</td>
                        <td class="value">
                            <span class="value-text">
                                {{ $paciente['nombre'] }} {{ $paciente['apellido_paterno'] }} {{ $paciente['apellido_materno'] }}
                            </span>
                        </td>
                    </tr>
                </table>

                <table class="data-table">
                    <!-- Fila 3: Nacimiento, Edad, Sexo -->
                    <tr>
                        <td width="1%" class="label">Nac.:</td>
                        <td class="value"><span class="value-text">{{ isset($paciente['fecha_nacimiento']) ? \Carbon\Carbon::parse($paciente['fecha_nacimiento'])->format('Y-m-d') : '' }}</span></td>
                        <td width="5"></td>
                        <td width="1%" class="label">Edad:</td>
                        <td width="10%" class="value"><span class="value-text">{{$paciente['age'] ?? ''}}</span></td>
                        <td width="5"></td>
                        <td width="1%" class="label">Sexo:</td>
                        <td width="10%" class="value"><span class="value-text">{{$paciente['sexo'] ?? ''}}</span></td>
                    </tr>
                </table>

                <table class="data-table">
                    <!-- Fila 4: Domicilio -->
                    <tr>
                        <td width="1%" class="label">Domicilio:</td>
                        <td class="value">
                            <span class="value-text" style="font-size: 7pt;">
                                {{ $paciente['calle'] ?? '' }} {{ $paciente['numero_exterior'] ?? '' }} {{ $paciente['colonia'] ?? '' }} {{ $paciente['municipio'] ?? '' }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>