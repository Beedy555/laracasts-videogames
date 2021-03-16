<div class="game mt-8 transition duration-150  hover:opacity-75 transform hover:scale-110">
    <div class="relative inline-block">
        <a href="{{ route('games.show', $game['slug']) }}">
            <img src="{{ $game['coverImageUrl'] }}"
                 alt="game cover"
                 class="">
        </a>
        @if (isset($game['rating']))
            <div id="{{ $game['slug'] }}" class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full"
                 style="right:-20px; bottom: -20px">
                @push('scripts')
                    @include('_rating', [
                        'slug' => $game['slug'],
                        'rating' => $game['rating'],
                        'event' => null
                    ])
                @endpush
            </div>
        @endif
    </div>
    <a href="{{ route('games.show', $game['slug']) }}"
       class="block text-base font-semibold leading-tight hover:text-gray-400 mt-8">
        {{ $game['name'] }}
        <div class="text-gray-400 mt-1">
            {{ $game['platforms'] }}
        </div>
    </a>
</div>
