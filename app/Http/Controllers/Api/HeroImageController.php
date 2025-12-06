<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HeroImageController extends Controller
{
    /**
     * Obtener todas las imágenes del hero
     */
    public function index(): JsonResponse
    {
        $images = HeroImage::all();
        
        return response()->json([
            'success' => true,
            'data' => $images
        ]);
    }

    /**
     * Actualizar una imagen del hero
     */
    public function update(Request $request, string $type): JsonResponse
    {
        try {
            $validated = $request->validate([
                'image_url' => 'nullable|string|url',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
                'badge_text' => 'nullable|string|max:255',
                'title' => 'nullable|string',
                'subtitle' => 'nullable|string',
                'cta_text' => 'nullable|string|max:255',
                'cta_action' => 'nullable|string|max:50',
                'cta_url' => 'nullable|string|url',
            ]);

            $heroImage = HeroImage::where('type', $type)->first();
            
            if (!$heroImage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tipo de imagen no encontrado'
                ], 404);
            }

            // Manejar subida de imagen
            if ($request->hasFile('image')) {
                $imagen = $request->file('image');
                $nombreImagen = 'hero_' . $type . '_' . time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                $imagen->storeAs('public/hero_images', $nombreImagen);
                $validated['image_url'] = url('storage/hero_images/' . $nombreImagen);
            }

            // Remover el campo temporal de imagen del request
            unset($validated['image']);

            $heroImage->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Datos actualizados exitosamente',
                'data' => $heroImage
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
