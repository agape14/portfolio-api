<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SectionController extends Controller
{
    /**
     * Obtener todas las secciones
     */
    public function index(): JsonResponse
    {
        $sections = Section::orderBy('orden', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $sections
        ]);
    }

    /**
     * Actualizar el estado de una sección
     */
    public function update(Request $request, string $slug): JsonResponse
    {
        try {
            $validated = $request->validate([
                'active' => 'required|boolean',
            ]);

            $section = Section::where('slug', $slug)->first();
            
            if (!$section) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sección no encontrada'
                ], 404);
            }

            $section->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Sección actualizada exitosamente',
                'data' => $section
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }
}
