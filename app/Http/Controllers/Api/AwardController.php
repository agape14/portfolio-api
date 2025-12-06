<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Award;

class AwardController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Award::orderBy('orden')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|string',
            'title' => 'required|string',
            'project' => 'required|string',
            'category' => 'required|string',
            'active' => 'boolean',
            'orden' => 'integer'
        ]);

        $award = Award::create($validated);

        return response()->json([
            'success' => true,
            'data' => $award
        ], 201);
    }

    public function show(Award $award)
    {
        return response()->json([
            'success' => true,
            'data' => $award
        ]);
    }

    public function update(Request $request, $id)
    {
        $award = Award::findOrFail($id);

        $validated = $request->validate([
            'year' => 'string',
            'title' => 'string',
            'project' => 'string',
            'category' => 'string',
            'active' => 'boolean',
            'orden' => 'integer'
        ]);

        $award->update($validated);

        return response()->json([
            'success' => true,
            'data' => $award
        ]);
    }

    public function destroy($id)
    {
        $award = Award::findOrFail($id);
        $award->delete();
        return response()->noContent();
    }
}
