<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class PopularGames extends Component
{

    public $popularGames = [];

    public function loadPopularGames(){

        $before = Carbon::now()->subMonths(2)->timestamp;
        $after = Carbon::now()->addMonths(2)->timestamp;

        $this->popularGames = Cache::remember('popular-games', 3600, function () use ($before, $after) {
            return Http::withHeaders(config('services.igdb.headers'))
                ->withBody(
                    "fields name, cover.url,first_release_date, platforms.abbreviation, total_rating, rating, slug;
        where platforms = (48, 49, 130, 6)
        & (first_release_date >= {$before}
        & first_release_date < {$after}
        & total_rating > 70);
        sort total_rating_count desc; limit 12;", 'text/plain'
                )->post('https://api.igdb.com/v4/games/')->json();
        });

    }

    public function render()
    {
        return view('livewire.popular-games');
    }
}
