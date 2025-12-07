<x-layouts.app :title="__('Artifacts')">
    <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Artifacts</h1>
    <div class="mx-auto max-w-7xl px-4 py-6">
        <livewire:create-artifact />
        <livewire:search :modelClass="App\Models\Artifact::class" hrefBase="/artifact" />
    </div>
</x-layouts.app>