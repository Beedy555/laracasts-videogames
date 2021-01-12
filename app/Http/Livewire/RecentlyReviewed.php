<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class RecentlyReviewed extends Component
{
    public $recentlyReviewed = [];

    public function loadRecentlyReviewed()
    {
        $current = Carbon::now()->timestamp;
        $before = Carbon::now()->subMonths(2)->timestamp;

        $this->recentlyReviewed = Cache::remember('recently-reviewed', 7, function () use ($current, $before) {
            return Http::withHeaders(config('services.igdb.headers'))
                ->withBody(
                    "fields name, cover.url,first_release_date, platforms.abbreviation, summary, total_rating_count, rating, slug;
        where platforms = (48, 49, 130, 6)
        & (first_release_date >= {$before}
        & first_release_date < {$current}
        & total_rating_count > 5);
        sort total_rating_count desc; limit 2;", 'text/plain'
                )->post('https://api.igdb.com/v4/games/')->json();
        });
    }

    public function render()
    {
        return view('livewire.recently-reviewed');
    }
}
