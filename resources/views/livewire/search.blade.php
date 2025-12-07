<!-- css handled by copilot during troubleshooting of page layouts, prompts found on respective pages -->

<div>
    <div class="mb-4">
        <input 
            type="search" 
            placeholder="Search..." 
            class="w-full rounded-lg border border-zinc-200 px-4 py-2 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100" 
            wire:model.live="query" 
        />
    </div>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 xl:grid-cols-5">
        @foreach ($this->records as $record)
                @php
                    $href = $hrefBase ? url($hrefBase.'/'.$record->id) : null;
                @endphp
                <x-record-card :record="$record" :href="$href" />
        @endforeach
    </div>
</div>