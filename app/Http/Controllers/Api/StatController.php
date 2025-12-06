<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StatController extends Controller
{
    /**
     * Obtener todas las estadísticas
     */
    public function index(): JsonResponse
    {
        $stats = Stat::orderBy('orden', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Obtener una estadística por ID
     */
    public function show(string $id): JsonResponse
    {
        $stat = Stat::find($id);
        
        if (!$stat) {
            return response()->json([
                'success' => false,
                'message' => 'Estadística no encontrada'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $stat
        ]);
    }

    /**
     * Crear una nueva estadística
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'label' => 'required|string|max:255',
                'value' => 'required|integer|min:0',
                'orden' => 'nullable|integer|min:0',
            ]);

            $stat = Stat::create($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Estadística creada exitosamente',
                'data' => $stat
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Actualizar una estadística
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $stat = Stat::find($id);
            
            if (!$stat) {
                return response()->json([
                    'success' => false,
                    'message' => 'Estadística no encontrada'
                ], 404);
            }

            $validated = $request->validate([
                'label' => 'required|string|max:255',
                'value' => 'required|integer|min:0',
                'orden' => 'nullable|integer|min:0',
            ]);

            $stat->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Estadística actualizada exitosamente',
                'data' => $stat
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Eliminar una estadística
     */
    public function destroy(string $id): JsonResponse
    {
        $stat = Stat::find($id);
        
        if (!$stat) {
            return response()->json([
                'success' => false,
                'message' => 'Estadística no encontrada'
            ], 404);
        }

        $stat->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Estadística eliminada exitosamente'
        ]);
    }
}
