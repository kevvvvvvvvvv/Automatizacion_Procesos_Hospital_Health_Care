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
    public function registrarMedicamentos($parent, array $medicamentos)
    {   
        if (empty($medicamentos)) {
            return;
        }

        foreach ($medicamentos as $med) {
            $productoId = $med['id'] ?? $med['medicamento_id'] ?? null;
            $nombre     = $med['nombre_medicamento'] ?? $med['nombre'] ?? '';
            $via        = $med['via_id'] ?? $med['via'] ?? '';

            $nuevoMedicamento = $parent->medicamentos()->create([
                'producto_servicio_id' => $productoId, 
                'nombre_medicamento'   => $nombre, 
                'dosis'                => $med['dosis'],
                'gramaje'              => $med['gramaje'],
                'via_administracion'   => $via,
                'fecha_hora_solicitud' => now(),
                'duracion_tratamiento' => $med['duracion'], 
                'unidad'               => $med['unidad'], 
                'estado'               => 'solicitado', 
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