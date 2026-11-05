<!-- This page handled by copilot
prompt: ok on this page I want to display the location information, then have a search box for the characters who are at the location, and another for the artifacts at the location
prompt: ok last thing, give me a way to edit and delete the individual locations on thier page. redirect to locations index after
prompt:now make it so taht the fields are only editable if the current user is the user who created the location  -->
<x-layouts.app :title="__('Location')">
    <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Location</h1>
	<div class="mx-auto max-w-7xl px-4 py-6">
		<div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
			<div class="flex flex-col gap-4 sm:flex-row">
				@if($location->image)
					<img src="{{ $location->image }}" alt="{{ $location->name }}" class="h-32 w-32 rounded-lg object-cover" />
				@endif
				<div class="flex-1">
					<h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $location->name }}</h1>
					<p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $location->description }}</p>
					<p class="mt-2 text-xs text-zinc-500 dark:text-zinc-500">Created by {{ $location->createdBy->name }}</p>
				</div>
			</div>
		</div>

		@if(auth()->check() && auth()->id() === $location->creator)
		<div class="mt-6" x-data="{ open: false }">
			<div class="flex justify-end">
				<button type="button" @click="open = !open" class="inline-flex items-center rounded bg-zinc-900 px-4 py-2 text-sm text-white dark:bg-zinc-100 dark:text-zinc-900">
					<span x-show="!open">Edit / Delete</span>
					<span x-show="open">Hide</span>
				</button>
			</div>

			<div class="mt-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800" x-show="open" x-transition>
			<h2 class="mb-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100">Edit Location</h2>
			<form method="POST" action="{{ route('locations.update', $location) }}" class="space-y-4">
				@csrf
				@method('PUT')
				<div>
					<label class="block text-sm font-medium">Name</label>
					<input type="text" name="name" value="{{ old('name', $location->name) }}" class="mt-1 w-full rounded border px-3 py-2 bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700" />
					@error('name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
				</div>
				<div>
					<label class="block text-sm font-medium">Description</label>
					<textarea name="description" rows="4" class="mt-1 w-full rounded border px-3 py-2 bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700">{{ old('description', $location->description) }}</textarea>
					@error('description')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
				</div>
				<div>
					<label class="block text-sm font-medium">Image URL (optional)</label>
					<input type="text" name="image" value="{{ old('image', $location->image) }}" class="mt-1 w-full rounded border px-3 py-2 bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700" />
					@error('image')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
				</div>
				<div class="flex justify-end gap-2">
					<a href="{{ route('locations.index') }}" class="inline-flex items-center rounded border px-3 py-2 text-sm dark:border-zinc-700">Cancel</a>
					<button type="submit" class="inline-flex items-center rounded bg-zinc-900 px-3 py-2 text-sm text-white dark:bg-zinc-100 dark:text-zinc-900">Save</button>
				</div>
			</form>

			<form method="POST" action="{{ route('locations.destroy', $location) }}" class="mt-4 flex justify-end" onsubmit="return confirm('Are you sure you want to delete this location?');">
				@csrf
				@method('DELETE')
				<button type="submit" class="inline-flex items-center rounded bg-red-600 px-3 py-2 text-sm text-white">Delete Location</button>
			</form>
		</div>
		@else
		<p class="mt-6 text-sm text-zinc-600 dark:text-zinc-400">Only the location creator can edit or delete this location.</p>
		@endif

		<div class="mt-8">
			<h2 class="mb-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100">Characters at this location</h2>
			<livewire:search :modelClass="App\Models\Character::class" :filters="['location' => $location->id]" hrefBase="/characters" />
		</div>

		<div class="mt-8">
			<h2 class="mb-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100">Artifacts at this location</h2>
			<livewire:search :modelClass="App\Models\Artifact::class" :filters="['location' => $location->id]" hrefBase="/artifacts" />
		</div>
	</div>
</x-layouts.app>