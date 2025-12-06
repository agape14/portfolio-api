<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Project::orderBy('order')->get()
        ]);
    }

    public function show(Project $project)
    {
        return $project;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120', // 5MB max
            'image_url' => 'nullable|string',
            'project_url' => 'nullable|url',
            'technologies' => 'nullable', // Can be JSON string or array
            'featured' => 'boolean',
            'order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/projects');
            $validated['image_url'] = \Illuminate\Support\Facades\Storage::url($path);
        }
        
        unset($validated['image']);

        // Handle technologies if it's a JSON string
        if (isset($validated['technologies']) && is_string($validated['technologies'])) {
            $validated['technologies'] = json_decode($validated['technologies'], true);
        }

        // Ensure image_url is null if empty string
        if (isset($validated['image_url']) && empty($validated['image_url'])) {
            $validated['image_url'] = null;
        }

        $project = Project::create($validated);
        return response()->json([
            'success' => true,
            'data' => $project
        ], 201);
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'image' => 'nullable|image|max:5120',
            'image_url' => 'nullable|string',
            'project_url' => 'nullable|url',
            'technologies' => 'nullable',
            'featured' => 'boolean',
            'order' => 'integer',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($project->image_url) {
                $oldPath = str_replace('/storage/', 'public/', $project->image_url);
                \Illuminate\Support\Facades\Storage::delete($oldPath);
            }

            $path = $request->file('image')->store('public/projects');
            $validated['image_url'] = \Illuminate\Support\Facades\Storage::url($path);
        }
        
        unset($validated['image']);

        if (isset($validated['technologies']) && is_string($validated['technologies'])) {
            $validated['technologies'] = json_decode($validated['technologies'], true);
        }

        $project->update($validated);
        return response()->json([
            'success' => true,
            'data' => $project
        ]);
    }

    public function destroy(Project $project)
    {
        if ($project->image_url) {
            $oldPath = str_replace('/storage/', 'public/', $project->image_url);
            \Illuminate\Support\Facades\Storage::delete($oldPath);
        }

        $project->delete();
        return response()->noContent();
    }
}
