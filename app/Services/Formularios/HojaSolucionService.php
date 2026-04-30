<?php

namespace App\Services\Formularios;

use App\Models\HojaMedicamento;
use App\Models\ProductoServicio;
use App\Models\User;
use App\Notifications\NuevaSolicitudMedicamentos;
use Illuminate\Support\Facades\Notification;
use Redirect;

class HojaMedicamentoService
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

        foreach ($soluciones as $sol) {
            $solucionId = $med['solucion_id'] ?? null;
            $nombre     = $med['nombre_solucion'] ?? '';
            $via        = $med['via_id'] ?? $med['via'] ?? '';

            $nuevoMedicamento = $parent->medicamentos()->create([
                'solucion'        => $solucionId, 
                'nombre_solucion' => $nombre, 
                'cantidad'        => $sol['cantidad'],
                'duracion'        => $sol['duracion'],
                'flujo'           => $sol['flujo'],
            ]);

            if ($nuevoMedicamento->producto_servicio_id) {
                $nuevoMedicamento->load('productoServicio');
            }
            $textoActual = $this->construirTextoMedicamentos(
                $nombre,
                $med['gramaje'],
                $med['dosis'],
                $med['unidad'],
                $via,
                $med['duracion']
            );

            if (!empty($textoActual)) {
                $textosMedicamentos[] = "• " . $textoActual;
            }
        }
        $textoManejoMedicamentos = implode("\n", $textosMedicamentos);

        $parent->update([
            'manejo_medicamentos' => $textoManejoMedicamentos
        ]);
    }

    /**
     * Sincroniza los medicamentos durante una edición (Borra los quitados, crea los nuevos).
     */
    public function sincronizarMedicamentos($parent, array $medicamentos)
    {
        $idsExistentesQueSeQuedan = collect($medicamentos)
            ->pluck('temp_id')
            ->filter(fn($id) => is_numeric($id)) 
            ->toArray();

        $parent->medicamentos()
            ->whereNotIn('id', $idsExistentesQueSeQuedan)
            ->where('estado', 'solicitado') 
            ->delete();

        $medicamentosNuevos = collect($medicamentos)
            ->filter(fn($med) => !is_numeric($med['temp_id']))
            ->toArray();

        if (!empty($medicamentosNuevos)) {
            $this->registrarMedicamentos($parent, $medicamentosNuevos);
        }
    }


    private function construirTextoMedicamentos(
        string $nombre_medicamento,
        string $gramaje,
        string $dosis,
        string $unidad,
        string $via,
        string $duracion
    ): string {

        $texto = sprintf(
            "%s%s - Tomar %s %s vía %s%s.",
            $nombre_medicamento,
            $gramaje,
            $dosis,
            $unidad,
            $via,
            $duracion
        );

        return trim(preg_replace('/\s+/', ' ', $texto));
    }
}