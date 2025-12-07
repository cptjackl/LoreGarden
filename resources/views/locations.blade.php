<x-layouts.app :title="__('Locations')">
    <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Locations</h1>
    <div class="mx-auto max-w-7xl px-4 py-6">
        <livewire:create-location />
        <livewire:search :modelClass="App\Models\Location::class" hrefBase="/location" />
    </div>
    
</x-layouts.app>