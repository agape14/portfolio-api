<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    /**
     * Obtener todos los settings o un setting específico
     */
    public function index(Request $request): JsonResponse
    {
        $key = $request->query('key');
        
        if ($key) {
            $setting = Setting::where('key', $key)->first();
            
            if (!$setting) {
                return response()->json([
                    'success' => false,
                    'message' => 'Setting no encontrado'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'key' => $setting->key,
                    'value' => $setting->value
                ]
            ]);
        }
        
        $settings = Setting::all()->mapWithKeys(function ($setting) {
            return [$setting->key => $setting->value];
        });
        
        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    /**
     * Actualizar un setting
     */
    public function update(Request $request, string $key): JsonResponse
    {
        $validated = $request->validate([
            'value' => 'required|string',
        ]);

        $setting = Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $validated['value']]
        );

        return response()->json([
            'success' => true,
            'message' => 'Setting actualizado exitosamente',
            'data' => [
                'key' => $setting->key,
                'value' => $setting->value
            ]
        ]);
    }
    /**
     * Subir una imagen para un setting (ej: favicon)
     */
    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg,ico,webp|max:2048', // Max 2MB, allow ico
            'key' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/settings', $filename, 'public');
            $url = asset('storage/' . $path);

            // Update the setting
            $setting = Setting::updateOrCreate(
                ['key' => $request->key],
                ['value' => $url]
            );

            return response()->json([
                'success' => true,
                'message' => 'Imagen subida exitosamente',
                'url' => $url,
                'data' => [
                    'key' => $setting->key,
                    'value' => $setting->value
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se ha subido ninguna imagen'
        ], 400);
    }
}
