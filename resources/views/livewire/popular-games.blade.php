<div wire:init="loadPopularGames"
     class="popular-games text-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12 border-b border-gray-800 pb-16">
    @forelse($popularGames as $game)
        <div class="game mt-8 transition duration-150  hover:opacity-75 transform hover:scale-110">
            <div class="relative inline-block">
                <a href="#">
                    <img src="{{ Str::replaceFirst('thumb', 'cover_big', $game['cover']['url']) }}"
                         alt="game cover"
                         class="">
                </a>
                @if (isset($game['rating']))
                    <div class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full "
                         style="right:-20px; bottom: -20px">
                        <div class="font-semibold text-xs flex justify-center items-center h-full">
                            {{ round($game['rating']).'%' }}
                        </div>
                    </div>
                @endif
            </div>
            <a href="#" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-8">
                {{ $game['name'] }}
                <div class="text-gray-400 mt-1">
                    {{ implode(', ', array_column($game['platforms'], 'abbreviation')) }}
                </div>
            </a>
        </div>
    @empty
        @foreach(range(1,12) as $game)
            <div class="game mt-8">
                <div class="relative inline-block">
                    <div class="bg-gray-800 w-44 h-56"></div>
                </div>
                <div class="block text-transparent text-lg bg-gray-700 rounded leading-tight mt-4">Title goes here</div>
                <div class="text-transparent bg-gray-700 rounded inline-block mt-3">PS4, PC, Switch</div>
            </div>
        @endforeach
    @endforelse
</div><!-- end popular-games -->
