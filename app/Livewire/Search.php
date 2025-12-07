<?php

namespace App\Livewire;

use Livewire\Component;


//Search component attempted by me, ended up using Copilot for troubleshooting and got it working, it did add a lot of css though on the component
//prompt: getting this error when I try to use the new search component... [insert stack trace]

class Search extends Component
{
    public $modelClass;
    public $query = '';
    public $filters = [];
    public $hrefBase = null;

    public function mount($modelClass, $filters = [], $hrefBase = null)
    {
        $this->modelClass = $modelClass;
        $this->filters = $filters;
        $this->hrefBase = $hrefBase;
    }

    public function getRecordsProperty()
    {
        $query = $this->modelClass::query();

        // Apply simple equality filters (e.g., ['location' => 123])
        foreach ($this->filters as $column => $value) {
            if ($value !== null && $value !== '') {
                $query->where($column, $value);
            }
        }

        if ($this->query) {
            $query->where('name', 'like', "%{$this->query}%")
                  ->orWhere('description', 'like', "%{$this->query}%");
        }

        return $query->get();
    }

    public function render()
    {
        return view('livewire.search');
    }
}
