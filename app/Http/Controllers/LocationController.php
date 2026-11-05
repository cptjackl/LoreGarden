<?php
namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function index()
    {
        
        $locations = Location::with('createdBy')->get();

        return view('/locations', ['locations' => $locations]);
    }

    public function show($id)
    {
        $location = Location::findOrFail($id);

        return view('location', ['location' => $location]);
    }

    public function create(Request $request)
    {
        $location = Location::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'creator' => Auth::id(),
        ]);

        return $location;
    }

    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);
        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['required','string'],
            'image' => ['nullable','string'],
        ]);
        $location->update($validated);

        return redirect()->route('locations.index');
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->route('locations.index');
    }
}
