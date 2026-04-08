Módulo de caja y tesorería
1. Visión general y arquitectura
Este módulo gestiona el flujo de dinero en efectivo dentro del hospital. La arquitectura se basa en un sistema de doble partida automatizado, centralizando toda la lógica matemática en un único servicio (CajaService) para garantizar la integridad de los datos y evitar descuadres.

Existen dos tipos principales de cuentas/cajas:

Cajas Operativas: Utilizadas por los cajeros de turno. Manejan ingresos por pacientes y operan bajo el concepto de "Turnos" (Sesiones de caja).

Bóveda (Contaduría): Cuenta central del hospital. Recibe los cortes de caja, provee "morralla" o fondo a las cajas operativas, y de aquí sale el dinero hacia el exterior (pago a proveedores, nóminas, etc.).

2. Reglas de Negocio (El flujo del dinero)
2.1 Envíos a bóveda (corte de caja)
Cuando un cajero retira exceso de efectivo de su cajón para enviarlo al contador, el sistema sigue este flujo estricto para mantener la congruencia física del dinero:

Egreso inmediato anticipado: En el momento en que el cajero hace clic en "Enviar", el sistema le registra un egreso en su turno. Esto asegura que si se hace un arqueo en ese mismo instante, su cajón cuadre perfectamente (el dinero ya no está físicamente ahí).

Tránsito (Estado Pendiente): Se genera un registro en SolicitudTraspaso en estado pendiente. El dinero está "en el pasillo" hacia contaduría.

Recepción en bóveda: Cuando el contador aprueba la recepción, el sistema detecta que el destino es la Bóveda y solo registra el Ingreso en la cuenta de Contaduría. Omite cobrarle de nuevo a la caja operativa para evitar el error de "doble egreso".

2.2 Manejo de Discrepancias y Rechazos
El sistema es tolerante a errores humanos y protege al cajero de la siguiente manera:

Rechazo Total: Si el contador rechaza la solicitud (ej. el sobre nunca llegó), el sistema le genera un Ingreso de Devolución a la caja operativa para regresarle el dinero a su saldo esperado.

Aprobación Parcial: Si el cajero declaró enviar $5,000 pero el contador solo recibió $4,800, el contador aprueba el monto real. El sistema detecta la diferencia y le genera un Ingreso de Ajuste a la caja operativa por esos $200. Esto fuerza a que el sistema del cajero marque un faltante real al cerrar su turno.

2.3 Egresos Externos (Gastos)
El dinero que sale definitivamente del hospital (pago de nómina, compra de insumos, etc.) se registra desde la Bóveda o el Fondo. Genera un movimiento directo de Egreso en la cuenta seleccionada, reflejándose instantáneamente en el "Libro Diario" del día.

3. Estructura del Backend (Laravel)
3.1 Clases Core
App\Services\CajaService.php: (CRÍTICO) Es el corazón del módulo. Los controladores tienen prohibido sumar o restar dinero directamente; todo debe pasar por los métodos de esta clase.

registrarMovimiento(): Inserta el movimiento universal en la base de datos, afectando el saldo de la sesión de caja.

enviarDineroABoveda(): Ejecuta el egreso inmediato al cajero y crea la solicitud de traspaso.

responderTraspaso(): Maneja la lógica inteligente de aprobación, rechazos, devoluciones y prevención de doble egreso.

3.2 Controladores
TraspasoController: Expone las rutas para que los cajeros soliciten dinero o envíen cortes (enviarABoveda).

BovedaController: Expone las rutas exclusivas de contaduría, como el registro de gastos externos (registrarGasto).

3.3 Validaciones (Form Requests)
Toda la entrada de datos está fuertemente tipada y traducida al español mediante Form Requests de Laravel.

Validación de Arrays: Se utiliza sintaxis con comodines (desglose.*.cantidad) para validar tablas dinámicas de denominaciones de billetes/monedas.

Validaciones Condicionales: Se implementa required_if (ej. exigir monto solo si la respuesta es "Aprobar") con mensajes humanizados ("Debes ingresar un monto a aprobar si decides autorizar").

Validaciones Enum: Se bloquean inyecciones de estado usando Illuminate\Validation\Rules\Enum atado a TipoMovimientoCaja::class.

4. Estructura del Frontend (React + Inertia)
4.1 Componentes Principales
DashboardBoveda.tsx: Panel principal de Contaduría. Implementa un sistema de pestañas para alternar entre "Solicitudes Pendientes" y "Libro Diario (Hoy)".

Tarjetas de Flujo: Componentes visuales que calculan en tiempo real el Total Ingresos, Total Egresos y el Flujo Neto del día en la Bóveda.

4.2 Modales de Acción
ModalEnviarCajaAConta.tsx: Formulario del cajero para mandar cortes. Consume la ruta traspasos.enviarABoveda.

ModalGastoBoveda.tsx: Formulario del contador para sacar dinero hacia proveedores. Consume la ruta boveda.registrarGasto.

Nota UX: Todos los modales implementan bloqueo de botones durante la petición (processing) para evitar envíos duplicados, y utilizan SweetAlert2 para retroalimentación visual al usuario.