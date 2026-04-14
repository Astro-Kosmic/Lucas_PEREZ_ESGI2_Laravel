@props(['pokemon', 'size' => 'w-24 h-24'])

<div class="relative inline-block">
    <img src="{{ $pokemon->sprite_url }}"
         alt="{{ $pokemon->name }}"
         class="{{ $size }}"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
    <div class="hidden {{ $size }} bg-gray-200 rounded-lg items-center justify-center text-xl font-bold text-gray-500">
        #{{ $pokemon->pokedex_number }}
    </div>
</div>
