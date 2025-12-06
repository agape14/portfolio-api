<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Obtener el perfil (solo habrá uno)
     */
    public function index(): JsonResponse
    {
        $profile = Profile::first();
        
        // Si no existe, crear uno por defecto
        if (!$profile) {
            $profile = Profile::create([
                'bio' => 'I am a passionate developer with years of experience creating beautiful and functional web applications.',
                'profile_picture_url' => null,
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }

    /**
     * Actualizar el perfil
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'headline' => 'nullable|string|max:255',
                'github_url' => 'nullable|string|url',
                'contact_email' => 'nullable|email|max:255',
                'linkedin_url' => 'nullable|string|url',
                'twitter_url' => 'nullable|string|url',
                'instagram_url' => 'nullable|string|url',
                'bio' => 'nullable|string',
                'profile_picture_url' => 'nullable|string|url',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            ]);

            $profile = Profile::first();
            
            if (!$profile) {
                $profile = Profile::create([]);
            }

            // Manejar subida de imagen
            if ($request->hasFile('profile_picture')) {
                $imagen = $request->file('profile_picture');
                $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                $imagen->storeAs('public/profiles', $nombreImagen);
                $validated['profile_picture_url'] = url('storage/profiles/' . $nombreImagen);
            }

            // Remover el campo temporal de imagen del request
            unset($validated['profile_picture']);

            $profile->update($validated);
            
            return response()->json([
                'success' => true,
                'message' => 'Perfil actualizado exitosamente',
                'data' => $profile
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
