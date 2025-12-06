<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Testimonial::orderBy('orden')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'role' => 'nullable|string',
            'quote' => 'required|string',
            'rating' => 'integer|min:1|max:5',
            'avatar' => 'nullable|image|max:2048',
            'avatar_url' => 'nullable|string',
            'active' => 'boolean',
            'orden' => 'integer'
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('public/testimonials');
            $validated['avatar_url'] = Storage::url($path);
        }

        $testimonial = Testimonial::create($validated);

        return response()->json([
            'success' => true,
            'data' => $testimonial
        ], 201);
    }

    public function show(Testimonial $testimonial)
    {
        return response()->json([
            'success' => true,
            'data' => $testimonial
        ]);
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string',
            'role' => 'nullable|string',
            'quote' => 'string',
            'rating' => 'integer|min:1|max:5',
            'avatar' => 'nullable|image|max:2048',
            'avatar_url' => 'nullable|string',
            'active' => 'boolean',
            'orden' => 'integer'
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($testimonial->avatar_url) {
                $oldPath = str_replace('/storage/', 'public/', $testimonial->avatar_url);
                Storage::delete($oldPath);
            }
            
            $path = $request->file('avatar')->store('public/testimonials');
            $validated['avatar_url'] = Storage::url($path);
        }

        $testimonial->update($validated);

        return response()->json([
            'success' => true,
            'data' => $testimonial
        ]);
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        if ($testimonial->avatar_url) {
            $oldPath = str_replace('/storage/', 'public/', $testimonial->avatar_url);
            Storage::delete($oldPath);
        }
        
        $testimonial->delete();
        return response()->noContent();
    }
}
