<!-- css handled by copilot witha few prompts and trouble shooting
prompt: ok great that worked. can you use some tailwind css to make the record card look nicer?...
     ...Make the record cards more square, and thin enough that about 5 of them can fit horizontally on the screen-->



@props(['record', 'href', 'compact' => false])

@php
    $imageUrl = $record->image;
@endphp

<div class="relative flex h-full flex-col overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm transition-shadow hover:shadow-md dark:border-zinc-700 dark:bg-zinc-800 {{ $compact ? 'max-w-xs' : '' }}">
        <a href="{{ $href }}" class="absolute inset-0 z-10" wire:navigate>
            <span class="sr-only">View {{ $record->name }}</span>
        </a>
    @if ($imageUrl)
        <div class="h-24 bg-cover bg-center {{ $compact ? 'h-16' : '' }}" style="background-image: url('{{ $imageUrl }}')">
            <div class="h-full w-full bg-gradient-to-t from-black/40 to-transparent"></div>
        </div>
    @endif

    <div class="p-3 {{ $compact ? 'p-2' : '' }}">
        <h3 class="truncate text-sm font-semibold text-zinc-900 dark:text-zinc-100 {{ $compact ? 'text-xs' : '' }}">
            {{ $record->name }}
        </h3>

        <p class="mt-2 line-clamp-3 text-xs text-zinc-600 dark:text-zinc-400 {{ $compact ? 'line-clamp-2 text-xs' : '' }}">
            {{ $record->description }}
        </p>

        <p class="mt-2 text-[11px] text-zinc-500 dark:text-zinc-500">
            {{ $record->createdBy->name }}
        </p>
    </div>
</div>