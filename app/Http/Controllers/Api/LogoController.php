<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    public function index()
    {
        return Logo::orderBy('orden')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'image_url' => 'required|string',
            'active' => 'boolean',
            'orden' => 'integer'
        ]);

        return Logo::create($validated);
    }

    public function show(Logo $logo)
    {
        return $logo;
    }

    public function update(Request $request, Logo $logo)
    {
        $validated = $request->validate([
            'name' => 'string',
            'image_url' => 'string',
            'active' => 'boolean',
            'orden' => 'integer'
        ]);

        $logo->update($validated);
        return $logo;
    }

    public function destroy(Logo $logo)
    {
        $logo->delete();
        return response()->noContent();
    }
}
