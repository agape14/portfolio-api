<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProyectoController extends Controller
{
    /**
     * Listar todos los proyectos
     */
    public function index(): JsonResponse
    {
        $proyectos = Proyecto::orderBy('orden', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $proyectos
        ]);
    }

    /**
     * Crear un nuevo proyecto
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'descripcion' => 'nullable|string',
                'imagen_url' => 'nullable|string',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
                'url_proyecto' => 'nullable|string|url',
                'tecnologias' => 'nullable',
                'orden' => 'nullable|integer|min:0',
                'destacado' => 'nullable',
            ]);

            // Procesar tecnologías si viene como JSON string
            if (isset($validated['tecnologias']) && is_string($validated['tecnologias'])) {
                $validated['tecnologias'] = json_decode($validated['tecnologias'], true) ?? [];
            }
            
            // Procesar destacado si viene como string
            if (isset($validated['destacado'])) {
                $validated['destacado'] = $validated['destacado'] === '1' || $validated['destacado'] === true || $validated['destacado'] === 'true';
            }

            // Si se subió una imagen, guardarla y obtener la URL
            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                $imagen->storeAs('public/proyectos', $nombreImagen);
                $validated['imagen_url'] = url('storage/proyectos/' . $nombreImagen);
            }

            $proyecto = Proyecto::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Proyecto creado exitosamente',
                'data' => $proyecto
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
     * Obtener un proyecto específico
     */
    public function show(int $id): JsonResponse
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json([
                'success' => false,
                'message' => 'Proyecto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $proyecto
        ]);
    }

    /**
     * Actualizar un proyecto (soporta PUT y POST para FormData)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $proyecto = Proyecto::find($id);

            if (!$proyecto) {
                return response()->json([
                    'success' => false,
                    'message' => 'Proyecto no encontrado'
                ], 404);
            }

            $validated = $request->validate([
                'titulo' => 'sometimes|required|string|max:255',
                'descripcion' => 'nullable|string',
                'imagen_url' => 'nullable|string',
                'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
                'url_proyecto' => 'nullable|string|url',
                'tecnologias' => 'nullable',
                'orden' => 'nullable|integer|min:0',
                'destacado' => 'nullable',
            ]);

            // Procesar tecnologías si viene como JSON string
            if (isset($validated['tecnologias']) && is_string($validated['tecnologias'])) {
                $validated['tecnologias'] = json_decode($validated['tecnologias'], true) ?? [];
            }
            
            // Procesar destacado si viene como string
            if (isset($validated['destacado'])) {
                $validated['destacado'] = $validated['destacado'] === '1' || $validated['destacado'] === true || $validated['destacado'] === 'true';
            }

            // Si se subió una nueva imagen, guardarla y obtener la URL
            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($proyecto->imagen_url && strpos($proyecto->imagen_url, 'storage/proyectos') !== false) {
                    $imagenAnterior = str_replace(url(''), '', $proyecto->imagen_url);
                    $imagenAnterior = str_replace('storage/', 'app/public/', $imagenAnterior);
                    if (file_exists(storage_path($imagenAnterior))) {
                        unlink(storage_path($imagenAnterior));
                    }
                }
                
                $imagen = $request->file('imagen');
                $nombreImagen = time() . '_' . uniqid() . '.' . $imagen->getClientOriginalExtension();
                $imagen->storeAs('public/proyectos', $nombreImagen);
                $validated['imagen_url'] = url('storage/proyectos/' . $nombreImagen);
            } elseif (!isset($validated['imagen_url'])) {
                // Si no se envía imagen_url, mantener la actual
                unset($validated['imagen_url']);
            }

            $proyecto->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Proyecto actualizado exitosamente',
                'data' => $proyecto
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
     * Eliminar un proyecto
     */
    public function destroy(int $id): JsonResponse
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json([
                'success' => false,
                'message' => 'Proyecto no encontrado'
            ], 404);
        }

        $proyecto->delete();

        return response()->json([
            'success' => true,
            'message' => 'Proyecto eliminado exitosamente'
        ]);
    }
}

