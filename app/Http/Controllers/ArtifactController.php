<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artifact;
use App\Models\Character;
use App\Models\Location;

class ArtifactController extends Controller
{

    
    public function index()
    {
        $artifacts = Artifact::all();

        return view('/artifacts', ['artifacts' => $artifacts]);
    }

    public function show($id)
    {
        $artifact = Artifact::findOrFail($id);
        $characters = Character::orderBy('name')->get(['id', 'name']);
        $locations = Location::orderBy('name')->get(['id', 'name']);

        return view('/artifact', ['artifact' => $artifact, 'characters' => $characters, 'locations' => $locations]);
    }

    public function update(Request $request, $id)
    {
        $artifact = Artifact::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'string'],
            'owner' => ['nullable', 'integer', 'exists:characters,id'],
            'location' => ['nullable', 'integer', 'exists:locations,id'],
        ]);
        $artifact->update($validated);

        return redirect()->route('artifacts.show', $artifact);
    }

    public function destroy($id)
    {
        $artifact = Artifact::findOrFail($id);
        $artifact->delete();

        return redirect()->route('artifacts.index');
    }
}
