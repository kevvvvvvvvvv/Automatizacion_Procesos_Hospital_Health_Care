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

            // 1. Creamos la solución
            $nuevaSolucion = $parent->soluciones()->create([
                'solucion'        => $solucionId,
                'nombre_solucion' => $nombre,
                'cantidad'        => $cantidad,
                'duracion'        => $duracion,
                'flujo_ml_hora'   => $flujo,
            ]);

            // 2. Extraemos los medicamentos
            $medicamentos = $sol['medicamentos'] ?? [];
            
            // Arreglo temporal para guardar los nombres de los medicamentos para el texto
            $nombresMedicamentosParaTexto = [];

            // 3. Guardamos cada medicamento (SIN el dd)
            foreach ($medicamentos as $med) {
                $nombreMed = $med['nombre_medicamento'] ?? '';
                
                if ($nombreMed) {
                    $nombresMedicamentosParaTexto[] = $nombreMed;
                }

                $nuevaSolucion->medicamentos()->create([
                    'producto_servicio_id' => $med['producto_servicio_id'] ?? null,
                    'nombre_medicamento'   => $nombreMed,
                    'dosis'                => $med['dosis'] ?? '',
                    'unidad_medida'        => $med['unidad_medida'] ?? '',
                ]);
            }

            // 4. Construimos el texto INCLUYENDO la lista de medicamentos
            $textoActual = $this->construirTextoSolucion(
                $nombre, 
                (string)$cantidad, 
                (string)$duracion, 
                (string)$flujo,
                $nombresMedicamentosParaTexto // <- Le pasamos el arreglo de nombres
            );

            if (!empty($textoActual)) {
                $textosSoluciones[] = "• " . $textoActual;
            }
        }

        // 5. Opcional: Si en este método también actualizas el modelo padre con el texto
        if (!empty($textosSoluciones)) {
            $parent->update([
                'manejo_soluciones' => implode("\n", $textosSoluciones)
            ]);
        }
    }

    public function sincronizarSoluciones($parent, array $soluciones)
    {
        // 1. Ahora buscamos el ID ya sea en 'id' o en 'temp_id' (si es numérico)
        $idsExistentesQueSeQuedan = collect($soluciones)
            ->map(fn($sol) => $sol['id'] ?? $sol['temp_id'] ?? null)
            ->filter(fn($id) => is_numeric($id)) // Solo nos quedamos con números (ignoramos los UUID)
            ->toArray();
 
        if (!empty($soluciones)) {
            $parent->soluciones()
                ->whereNotIn('id', $idsExistentesQueSeQuedan)
                ->delete();
        }

        $textosSoluciones = [];

        foreach ($soluciones as $solData) {
            try {
                // Sacamos el ID real validando si temp_id es numérico
                $realId = $solData['id'] ?? $solData['temp_id'] ?? null;
                $esExistente = is_numeric($realId);

                if ($esExistente) {
                    // ACTUALIZACIÓN (UPDATE)
                    $solucionModelo = $parent->soluciones()->find($realId);
                    
                    if ($solucionModelo) {
                        // Si solucion_id viene null pero la base de datos ya tenía uno, lo conservamos
                        $idCatalogo = $solData['solucion_id'] ?? $solucionModelo->solucion;

                        $solucionModelo->update([
                            'solucion'        => $idCatalogo,
                            'nombre_solucion' => $solData['nombre_solucion'] ?? '',
                            'cantidad'        => $solData['cantidad'] ?? 0,
                            'duracion'        => $solData['duracion'] ?? 0,
                            'flujo_ml_hora'   => $solData['flujo'] ?? 0,
                        ]);
                    }
                } else {
                    // CREACIÓN (CREATE)
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