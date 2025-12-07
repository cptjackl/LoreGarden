<x-layouts.app :title="__('Characters')">
    <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Characters</h1>
    <div class="mx-auto max-w-7xl px-4 py-6">
        <livewire:create-character />
        <livewire:search :modelClass="App\Models\Character::class" hrefBase="/character" />
    </div>
</x-layouts.app>