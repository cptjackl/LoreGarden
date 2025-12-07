<?php

namespace App\Livewire;

use App\Models\Character;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

//page and logic handled by copilot
//prompt: great, now I need the same form for the characters, add a dropdown list to select a location for them to be at


class CreateCharacter extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string')]
    public string $description = '';

    public $image; // optional path/url

    // Column is named 'location' in schema (FK to locations.id)
    #[Validate('nullable|integer|exists:locations,id')]
    public $location = null;

    public bool $open = false;

    public function openModal(): void
    {
        $this->resetErrorBag();
        $this->open = true;
    }

    public function closeModal(): void
    {
        $this->open = false;
    }

    public function save(): void
    {
        $this->validate();

        $imageUrl = $this->image ?: 'https://picsum.photos/id/' . mt_rand(1, 100) . '/200';

        Character::create([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $imageUrl,
            'location' => $this->location, // nullable FK
            'creator' => Auth::id(),
        ]);

        // Refresh the list via redirect
        redirect()->to('/characters');
    }

    public function render()
    {
        // Provide locations for dropdown
        $locations = Location::orderBy('name')->get(['id', 'name']);
        return view('livewire.create-character', compact('locations'));
    }
}
