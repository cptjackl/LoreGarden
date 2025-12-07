<!-- This page handled by copilot
prompt: ok on this page I want to display the location information, then have a search box for the characters who are at the location, and another for the artifacts at the location
prompt: great, add the same create/edit/delete functionality from locations and characters to the artifacts page -->
<x-layouts.app :title="__('Artifact')">
    <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Artifact</h1>
	<div class="mx-auto max-w-7xl px-4 py-6">
		<div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
			<div class="flex flex-col gap-4 sm:flex-row">
				@if($artifact->image)
					<img src="{{ $artifact->image }}" alt="{{ $artifact->name }}" class="h-32 w-32 rounded-lg object-cover" />
				@endif
				<div class="flex-1">
					<h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $artifact->name }}</h1>
					<p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">{{ $artifact->description }}</p>
					<p class="mt-2 text-xs text-zinc-500 dark:text-zinc-500">Created by {{ $artifact->createdBy->name }}</p>
				</div>
			</div>
		</div>

		@if(auth()->check() && auth()->id() === $artifact->creator)
		<div class="mt-6" x-data="{ open: false }">
			<div class="flex justify-end">
				<button type="button" @click="open = !open" class="inline-flex items-center rounded bg-zinc-900 px-4 py-2 text-sm text-white dark:bg-zinc-100 dark:text-zinc-900">
					<span x-show="!open">Edit / Delete</span>
					<span x-show="open">Hide</span>
				</button>
			</div>

			<div class="mt-6 rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800" x-show="open" x-transition>
				<h2 class="mb-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100">Edit Artifact</h2>
				<form method="POST" action="{{ route('artifact.update', ['id' => $artifact->id]) }}" class="space-y-4">
					@csrf
					@method('PUT')
					<div>
						<label class="block text-sm font-medium">Name</label>
						<input type="text" name="name" value="{{ old('name', $artifact->name) }}" class="mt-1 w-full rounded border px-3 py-2 bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700" />
						@error('name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium">Description</label>
						<textarea name="description" rows="4" class="mt-1 w-full rounded border px-3 py-2 bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700">{{ old('description', $artifact->description) }}</textarea>
						@error('description')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium">Image URL (optional)</label>
						<input type="text" name="image" value="{{ old('image', $artifact->image) }}" class="mt-1 w-full rounded border px-3 py-2 bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700" />
						@error('image')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium">Owner (Character, optional)</label>
						<select name="owner" class="mt-1 w-full rounded border px-3 py-2 bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700">
							<option value="">-- None --</option>
							@foreach($characters as $char)
								<option value="{{ $char->id }}" @selected(old('owner', $artifact->owner) == $char->id)>{{ $char->name }}</option>
							@endforeach
						</select>
						@error('owner')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
					</div>
					<div>
						<label class="block text-sm font-medium">Location (optional)</label>
						<select name="location" class="mt-1 w-full rounded border px-3 py-2 bg-zinc-100 text-zinc-900 dark:bg-zinc-800 dark:text-zinc-100 dark:border-zinc-700">
							<option value="">-- None --</option>
							@foreach($locations as $loc)
								<option value="{{ $loc->id }}" @selected(old('location', $artifact->location) == $loc->id)>{{ $loc->name }}</option>
							@endforeach
						</select>
						@error('location')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
					</div>
					<div class="flex justify-end gap-2">
						<a href="{{ route('artifact.display', ['id' => $artifact->id]) }}" class="inline-flex items-center rounded border px-3 py-2 text-sm dark:border-zinc-700">Cancel</a>
						<button type="submit" class="inline-flex items-center rounded bg-zinc-900 px-3 py-2 text-sm text-white dark:bg-zinc-100 dark:text-zinc-900">Save</button>
					</div>
				</form>

				<form method="POST" action="{{ route('artifact.delete', ['id' => $artifact->id]) }}" class="mt-4 flex justify-end" onsubmit="return confirm('Are you sure you want to delete this artifact?');">
					@csrf
					@method('DELETE')
					<button type="submit" class="inline-flex items-center rounded bg-red-600 px-3 py-2 text-sm text-white">Delete Artifact</button>
				</form>
			</div>
		</div>
		@else
		<p class="mt-6 text-sm text-zinc-600 dark:text-zinc-400">Only the artifact creator can edit or delete this artifact.</p>
		@endif

		@if($artifact->owner)
		<div class="mt-8">
			<h2 class="mb-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100">Owner</h2>
			@php
				$owner = $artifact->relationLoaded('ownedBy') ? $artifact->ownedBy : \App\Models\Character::find($artifact->owner);
				$href = route('character.display', ['id' => $owner->id]);
			@endphp
			<x-record-card :record="$owner" :href="$href" compact />
		</div>
		@endif

		@if($artifact->location)
		<div class="mt-8">
			<h2 class="mb-3 text-lg font-semibold text-zinc-900 dark:text-zinc-100">Location</h2>
			@php
				$location = $artifact->relationLoaded('location') ? $artifact->location : \App\Models\Location::find($artifact->location);
				$href = route('location.display', ['id' => $location->id]);
			@endphp
			<x-record-card :record="$location" :href="$href" compact />
		</div>
		@endif
	</div>
</x-layouts.app>