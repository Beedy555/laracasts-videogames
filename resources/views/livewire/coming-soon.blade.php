<div wire:init="loadComingSoon" class="space-y-10 mt-8">
    @forelse($comingSoon as $game)
        <div class="game flex">
            <div class="ml-0">
                <a href="#" class="hover:text-gray-400">{{ $game['name'] }}</a>
                <div class="text-gray-400 text-sm mt-1">
                    <span>{{ $game['platforms'] }}</span>
                    -
                    <span>{{ $game['firstReleaseDate'] }}</span>
                </div>
            </div>
        </div>
    @empty
        @foreach(range(1,4) as $game)
            <div class="game flex">
                <div class="ml-0">
                    <div class=" text-transparent bg-gray-700 rounded leading-tight">Title goes here today</div>
                    <div class="text-transparent bg-gray-700 rounded inline-block mt-2">Jan 10, 2021</div>
                </div>
            </div>
        @endforeach
    @endforelse
</div>
