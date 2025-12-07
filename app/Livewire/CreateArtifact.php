<?php

namespace App\Livewire;

use App\Models\Artifact;
use App\Models\Character;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateArtifact extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string')]
    public string $description = '';

    public $image; // optional path/url

    #[Validate('nullable|integer|exists:characters,id')]
    public $owner = null;

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

        Artifact::create([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $imageUrl,
            'owner' => $this->owner,
            'location' => $this->location,
            'creator' => Auth::id(),
        ]);

        // Refresh the list via redirect
        redirect()->to('/artifacts');
    }

    public function render()
    {
        // Provide characters and locations for dropdowns
        $characters = Character::orderBy('name')->get(['id', 'name']);
        $locations = Location::orderBy('name')->get(['id', 'name']);
        return view('livewire.create-artifact', compact('characters', 'locations'));
    }
}
