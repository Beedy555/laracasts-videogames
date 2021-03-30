<div class="relative">
    <input wire:model.debounce.300ms="search" type="text"
           class="bg-gray-800 text-sm rounded-full focus:outline-none focus:shadow-outline w-64 px-3 py-1 pl-8"
           placeholder="Search...">

    <div class="absolute top-0 flex items-center ml-2 mt-1">
        <svg class="fill-current text-gray-400 w-5" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0016 9.5 6.5 6.5 0 109.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
            <path d="M0 0h24v24H0z" fill="none"/>
        </svg>
    </div>

    <div wire:loading class="top-0 right-0 mr-4 mt-2" style="position: absolute"><livewire:spinner/></div>

    @if(strlen($search) >= 2)
        <div class="absolute z-50 bg-gray-800 text-xs rounded w-64 mt-2">
            @if(count($searchResults) > 0)
                <ul class="divide-y divide-gray-700">
                    @foreach($searchResults as $game)
                        @isset($game['game'])
                            <li><a href="{{ route('games.show', $game['game']['slug']) }}"
                                   class="block hover:bg-gray-700 px-3 py-3 flex items-center transition ease-in-out duration-150">
                                    @isset($game['game']['cover'])
                                        <img
                                            src="{{ Str::replaceFirst('thumb', 'cover_small', $game['game']['cover']['url']) }}"
                                            class="w-10"
                                            alt="cover">
                                    @else
                                        <img
                                            src="https://via.placeholder.com/264x352"
                                            class="w-10"
                                            alt="game cover">
                                    @endif
                                    <span class="ml-4">{{ $game['name'] }}</span>
                                </a></li>
                        @endisset
                    @endforeach
                </ul>
            @else
                <div class="px-3 py-3">No results found for "{{ $search }}"</div>
            @endif
        </div>
    @endif
</div>
