<!-- created by co-pilot
prompt:OK great, now for the Dashboard page I want it to display a searchable box (like seen on the locations, artifacts, and characters pages) that shows the locations the current user has created, then the characters, then the artifacts. If noe have been created there should be a message that says as much. Have welcom message near the top of the page -->

<x-layouts.app :title="__('Dashboard')">
   <div class="mx-auto max-w-7xl px-4 py-6 space-y-8">
      <div>
         <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Dashboard</h1>
         <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Welcome back, {{ auth()->user()->name }}. Here are the things you've created.</p>
      </div>

      @php
         $userId = auth()->id();
         $locationCount = \App\Models\Location::where('creator', $userId)->count();
         $characterCount = \App\Models\Character::where('creator', $userId)->count();
         $artifactCount = \App\Models\Artifact::where('creator', $userId)->count();
      @endphp

      <div class="space-y-4">
         <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Your Locations</h2>
         @if($locationCount === 0)
            <p class="text-sm text-zinc-600 dark:text-zinc-400">You haven't created any locations yet.</p>
         @else
            <livewire:search :modelClass="App\Models\Location::class" :filters="['creator' => $userId]" hrefBase="/locations" />
         @endif
      </div>

      <div class="space-y-4">
         <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Your Characters</h2>
         @if($characterCount === 0)
            <p class="text-sm text-zinc-600 dark:text-zinc-400">You haven't created any characters yet.</p>
         @else
            <livewire:search :modelClass="App\Models\Character::class" :filters="['creator' => $userId]" hrefBase="/characters" />
         @endif
      </div>

      <div class="space-y-4">
         <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Your Artifacts</h2>
         @if($artifactCount === 0)
            <p class="text-sm text-zinc-600 dark:text-zinc-400">You haven't created any artifacts yet.</p>
         @else
            <livewire:search :modelClass="App\Models\Artifact::class" :filters="['creator' => $userId]" hrefBase="/artifacts" />
         @endif
      </div>
   </div>
</x-layouts.app>
