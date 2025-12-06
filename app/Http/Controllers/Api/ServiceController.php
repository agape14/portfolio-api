<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Service::orderBy('orden')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'icon' => 'nullable|string', // Emoji or class
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'active' => 'boolean',
            'orden' => 'integer'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/services');
            $validated['image_url'] = Storage::url($path);
        }
        
        // Remove 'image' from validated data as it's not a column
        unset($validated['image']);

        $service = Service::create($validated);

        return response()->json([
            'success' => true,
            'data' => $service
        ], 201);
    }

    public function show(Service $service)
    {
        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'string',
            'description' => 'string',
            'icon' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'active' => 'boolean',
            'orden' => 'integer'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($service->image_url) {
                $oldPath = str_replace('/storage/', 'public/', $service->image_url);
                Storage::delete($oldPath);
            }
            
            $path = $request->file('image')->store('public/services');
            $validated['image_url'] = Storage::url($path);
        }
        
        unset($validated['image']);

        $service->update($validated);

        return response()->json([
            'success' => true,
            'data' => $service
        ]);
    }

    public function destroy(Service $service)
    {
        if ($service->image_url) {
            $oldPath = str_replace('/storage/', 'public/', $service->image_url);
            Storage::delete($oldPath);
        }
        
        $service->delete();
        return response()->noContent();
    }
}
