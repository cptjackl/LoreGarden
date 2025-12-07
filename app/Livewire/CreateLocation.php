<?php

namespace App\Livewire;

use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

// <!-- page and functionality were handled by copilot
// prompt: ok I now on the index pages I want a record creation button that pops up a form for creating the record, with all the fields and dropdown menus making sense -->


class CreateLocation extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string')]
    public string $description = '';

    public $image; // path string (optional)

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
        $imageUrl = $this->image ?: "https://picsum.photos/id/" . mt_rand(1, 100) . "/200";

        $location = Location::create([
            'name' => $this->name,
            'description' => $this->description,
            'image' => $imageUrl,
            'creator' => Auth::id(),
        ]);
        // Option B: simple page reload to reflect new record in the list
        redirect()->to('/locations');
    }

    public function render()
    {
        return view('livewire.create-location');
    }
}
