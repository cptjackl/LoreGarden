<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Character;
use App\Models\Location;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Character::all();

        return view('/characters', ['characters' => $characters]);
    }

    public function show($id)
    {
        $character = Character::findOrFail($id);
        $locations = Location::orderBy('name')->get(['id', 'name']);

        return view('character', ['character' => $character, 'locations' => $locations]);
    }

    public function update(Request $request, $id)
    {
        $character = Character::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'string'],
            'location' => ['nullable', 'integer', 'exists:locations,id'],
        ]);
        $character->update($validated);

        return redirect()->route('characters.show', $character);
    }

    public function destroy($id)
    {
        $character = Character::findOrFail($id);
        $character->delete();

        return redirect()->route('characters.index');
    }
}
