<?php

namespace App\Services\Formularios;

use App\Models\HojaMedicamento;
use App\Models\ProductoServicio;
use App\Models\User;
use App\Notifications\NuevaSolicitudMedicamentos;
use Illuminate\Support\Facades\Notification;
use Redirect;

class HojaSolucionService
{
    /**
     * Procesa y guarda un arreglo de medicamentos vinculados a un modelo padre.
     * * @param mixed $parent El modelo padre (Nota evolución, Nota postoperatoria e Indicaciones médicas.)
     * @param array $medicamentos El arreglo de medicamentos desde el Request
     */
    public function registrarSoluciones($parent, array $soluciones)
    {  
        
        if (empty($soluciones)) {
            return;
        }

        $textosSoluciones = [];

        foreach ($soluciones as $sol) {
            $solucionId = $sol['solucion_id'] ?? null;
            $nombre     = $sol['nombre_solucion'] ?? '';
            $cantidad   = $sol['cantidad'] ?? 0;
            $duracion   = $sol['duracion'] ?? 0;
            $flujo      = $sol['flujo'] ?? 0;

            $nuevaSolucion = $parent->soluciones()->create([
                'solucion'        => $solucionId,
                'nombre_solucion' => $nombre,
                'cantidad'        => $cantidad,
                'duracion'        => $duracion,
                'flujo_ml_hora'   => $flujo,
            ]);

            $medicamentos = $sol['medicamentos'] ?? [];

            foreach ($medicamentos as $med) {
                $nuevaSolucion->medicamentos()->create([
                    'producto_servicio_id' => $med['producto_servicio_id'] ?? null,
                    'nombre_medicamento'   => $med['nombre_medicamento'] ?? '',
                    'dosis'                => $med['dosis'] ?? '',
                    'unidad_medida'        => $med['unidad_medida'] ?? '',
                ]);
            }

            $textoActual = $this->construirTextoSolucion(
                $nombre, 
                (string)$cantidad, 
                (string)$duracion, 
                (string)$flujo
            );

            if (!empty($textoActual)) {
                $textosSoluciones[] = "• " . $textoActual;
            }
        }

        if (!empty($textosSoluciones)) {
            $textoManejoSoluciones = implode("\n", $textosSoluciones);

            $parent->update([
                'manejo_soluciones' => $textoManejoSoluciones
            ]);
        }
    }

    public function sincronizarSoluciones($parent, array $soluciones)
    {
        $idsExistentesQueSeQuedan = collect($soluciones)->pluck('id')->filter()->toArray();
 
        if (!empty($soluciones)) {
            $parent->soluciones()
                ->whereNotIn('id', $idsExistentesQueSeQuedan)
                ->delete();
        }

        $textosSoluciones = [];

        foreach ($soluciones as $solData) {
            try {
                if (!empty($solData['id'])) {
                    $solucionModelo = $parent->soluciones()->find($solData['id']);
                    if ($solucionModelo) {
                        $solucionModelo->update([
                            'solucion'        => $solData['solucion_id'] ?? null,
                            'nombre_solucion' => $solData['nombre_solucion'] ?? '',
                            'cantidad'        => $solData['cantidad'] ?? 0,
                            'duracion'        => $solData['duracion'] ?? 0,
                            'flujo_ml_hora'   => $solData['flujo'] ?? 0,
                        ]);
                    }
                } else {
                    $solucionModelo = $parent->soluciones()->create([
                        'solucion'        => $solData['solucion_id'] ?? null, 
                        'nombre_solucion' => $solData['nombre_solucion'] ?? '',
                        'cantidad'        => $solData['cantidad'] ?? 0,
                        'duracion'        => $solData['duracion'] ?? 0,
                        'flujo_ml_hora'   => $solData['flujo'] ?? 0,
                    ]);
                }

                $nombresMedicamentosParaTexto = [];

                if ($solucionModelo && isset($solData['medicamentos'])) {
                    
                    $medIdsQueSeQuedan = collect($solData['medicamentos'])
                        ->pluck('id')
                        ->filter()
                        ->toArray();

                    $solucionModelo->medicamentos()
                        ->whereNotIn('id', $medIdsQueSeQuedan)
                        ->delete();

                    foreach ($solData['medicamentos'] as $medData) {
                        
                        $nombreMed = $medData['nombre'] ?? $medData['nombre_medicamento'] ?? '';
                        if ($nombreMed) {
                            $nombresMedicamentosParaTexto[] = $nombreMed;
                        }

                        if (empty($medData['id'])) {
                            $solucionModelo->medicamentos()->create([
                                'producto_servicio_id' => $medData['producto_servicio_id'] ?? $medData['id'] ?? null, 
                                'nombre_medicamento'   => $nombreMed,
                                'dosis'                => $medData['dosis'] ?? '',
                                'unidad_medida'        => $medData['unidad'] ?? $medData['unidad_medida'] ?? '',
                            ]);
                        } else {
                            $medExistente = $solucionModelo->medicamentos()->find($medData['id']);
                            if ($medExistente) {
                                $medExistente->update([
                                    'producto_servicio_id' => $medData['producto_servicio_id'] ?? $medData['id'] ?? null,
                                    'nombre_medicamento'   => $nombreMed,
                                    'dosis'                => $medData['dosis'] ?? '',
                                    'unidad_medida'        => $medData['unidad'] ?? $medData['unidad_medida'] ?? '',
                                ]);
                            }
                        }
                    }
                }

                $textoActual = $this->construirTextoSolucion(
                    $solData['nombre_solucion'] ?? null,
                    (string)($solData['cantidad'] ?? ''),
                    (string)($solData['duracion'] ?? ''),
                    (string)($solData['flujo'] ?? ''),
                    $nombresMedicamentosParaTexto
                );

                if (!empty($textoActual)) {
                    $textosSoluciones[] = "• " . $textoActual;
                }

            } catch (\Exception $e) {
                dd("El código tronó en el foreach: " . $e->getMessage(), "Datos que causaron el error:", $solData);
            }
        }

        if (!empty($textosSoluciones)) {
            $parent->update([
                'manejo_soluciones' => implode("\n", $textosSoluciones)
            ]);
        }
    }


    /**
     * Construye una cadena de texto legible para el manejo de una solución y sus medicamentos.
     */
    private function construirTextoSolucion(
        ?string $nombre_solucion,
        ?string $cantidad,
        ?string $duracion,
        ?string $flujo_ml_hora,
        array $nombresMedicamentos = []
    ): string {
        
        $nombre = $nombre_solucion ?? 'Solución no especificada';
        $textoCantidad = $cantidad ? " $cantidad ml" : '';
        $textoFlujo = $flujo_ml_hora ? " a un flujo de $flujo_ml_hora ml/hr" : '';
        $textoDuracion = $duracion ? " durante $duracion horas" : '';

        $textoBase = sprintf(
            "%s%s%s%s",
            $nombre,
            $textoCantidad,
            $textoFlujo,
            $textoDuracion
        );

        if (!empty($nombresMedicamentos)) {
            $listaMeds = implode(', ', $nombresMedicamentos);
            $textoBase .= " con: " . $listaMeds;
        }

        $textoBase .= ".";

        return trim(preg_replace('/\s+/', ' ', $textoBase));
    }
}